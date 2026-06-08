<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $this->perPage();

        $validated = $this->validatedFilters($request);

        $logs = $this->reportQuery($validated)
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        return view('reports.index', [
            'logs' => $logs,
            'filters' => $validated,
            'perPage' => $perPage,
        ]);
    }

    public function exportCsv(Request $request)
    {
        $filters = $this->validatedFilters($request);
        $rows = $this->exportRows($filters);
        $filename = $this->exportFilename('csv');

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Kode', 'Barang', 'Kategori', 'Tipe', 'Jumlah', 'Stok Awal', 'Stok Akhir', 'Petugas', 'Catatan']);

            foreach ($rows as $row) {
                fputcsv($handle, array_values($row));
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $filters = $this->validatedFilters($request);
        $rows = $this->exportRows($filters);
        $filename = $this->exportFilename('pdf');
        $pdf = $this->buildPdf($rows, $filters);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'type' => ['nullable', 'in:masuk,keluar'],
        ]);
    }

    private function reportQuery(array $filters)
    {
        return InventoryLog::with('item.category', 'user')
            ->when($filters['start_date'] ?? null, fn ($query, $date) => $query->whereDate('date', '>=', $date))
            ->when($filters['end_date'] ?? null, fn ($query, $date) => $query->whereDate('date', '<=', $date))
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type));
    }

    private function exportRows(array $filters): Collection
    {
        return $this->reportQuery($filters)
            ->orderBy('date')
            ->orderBy('created_at')
            ->get()
            ->map(function (InventoryLog $log) {
                return [
                    'date' => $log->date->format('d/m/Y'),
                    'code' => $log->item?->item_code ?? $log->item_code_snapshot ?? '-',
                    'item' => $log->item?->name ?? ($log->item_name_snapshot ? 'Produk dihapus - '.$log->item_name_snapshot : 'Produk dihapus'),
                    'category' => $log->item?->category?->name ?? $log->category_name_snapshot ?? '-',
                    'type' => $log->type,
                    'quantity' => $log->quantity,
                    'stock_before' => $log->stock_before ?? '-',
                    'stock_after' => $log->stock_after ?? '-',
                    'user' => $log->user->name,
                    'notes' => $log->notes ?? '-',
                ];
            });
    }

    private function exportFilename(string $extension): string
    {
        return 'laporan-mutasi-stok-'.now()->format('Ymd-His').'.'.$extension;
    }

    private function buildPdf(Collection $rows, array $filters): string
    {
        $lines = [
            'LAPORAN MUTASI STOK',
            'Periode: '.($filters['start_date'] ?? 'Semua').' s/d '.($filters['end_date'] ?? 'Semua'),
            'Tipe: '.($filters['type'] ?? 'Semua'),
            'Dicetak: '.now()->format('d/m/Y H:i'),
            '',
            sprintf('%-10s %-10s %-26s %-16s %-7s %6s %10s %10s %-16s %s', 'Tanggal', 'Kode', 'Barang', 'Kategori', 'Tipe', 'Jumlah', 'Stok Awal', 'Stok Akhir', 'Petugas', 'Catatan'),
            str_repeat('-', 132),
        ];

        foreach ($rows as $row) {
            $lines[] = sprintf(
                '%-10s %-10s %-26s %-16s %-7s %6s %10s %10s %-16s %s',
                $row['date'],
                Str::limit($row['code'], 10, ''),
                Str::limit($row['item'], 26, ''),
                Str::limit($row['category'], 16, ''),
                $row['type'],
                $row['quantity'],
                $row['stock_before'],
                $row['stock_after'],
                Str::limit($row['user'], 16, ''),
                Str::limit($row['notes'], 24, '')
            );
        }

        if ($rows->isEmpty()) {
            $lines[] = 'Tidak ada data laporan.';
        }

        return $this->plainTextPdf($lines);
    }

    private function plainTextPdf(array $lines): string
    {
        $pages = array_chunk($lines, 34);
        $objects = [];
        $pageIds = [];
        $fontId = 3;

        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        $objects[2] = '';
        $objects[$fontId] = '<< /Type /Font /Subtype /Type1 /BaseFont /Courier >>';

        $nextId = 4;
        foreach ($pages as $pageIndex => $pageLines) {
            $contentId = $nextId++;
            $pageId = $nextId++;
            $pageIds[] = $pageId;

            $content = "BT\n/F1 8 Tf\n40 555 Td\n";
            foreach ($pageLines as $index => $line) {
                if ($index > 0) {
                    $content .= "0 -14 Td\n";
                }
                $content .= '('.$this->pdfEscape($line).") Tj\n";
            }
            $content .= "ET";

            $objects[$contentId] = "<< /Length ".strlen($content)." >>\nstream\n".$content."\nendstream";
            $objects[$pageId] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 842 595] /Resources << /Font << /F1 '.$fontId.' 0 R >> >> /Contents '.$contentId.' 0 R >>';
        }

        $objects[2] = '<< /Type /Pages /Kids ['.implode(' ', array_map(fn ($id) => $id.' 0 R', $pageIds)).'] /Count '.count($pageIds).' >>';

        ksort($objects);

        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $id => $object) {
            $offsets[$id] = strlen($pdf);
            $pdf .= $id." 0 obj\n".$object."\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 ".(max(array_keys($objects)) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";
        for ($id = 1; $id <= max(array_keys($objects)); $id++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$id] ?? 0);
        }
        $pdf .= "trailer\n<< /Size ".(max(array_keys($objects)) + 1)." /Root 1 0 R >>\nstartxref\n".$xrefOffset."\n%%EOF";

        return $pdf;
    }

    private function pdfEscape(string $text): string
    {
        $text = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text) ?: $text;

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
