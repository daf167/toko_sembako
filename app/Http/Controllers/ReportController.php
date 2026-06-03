<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $logs = InventoryLog::with('item.category', 'user')
            ->when($validated['start_date'] ?? null, fn ($query, $date) => $query->whereDate('date', '>=', $date))
            ->when($validated['end_date'] ?? null, fn ($query, $date) => $query->whereDate('date', '<=', $date))
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        return view('reports.index', [
            'logs' => $logs,
            'filters' => $validated,
        ]);
    }
}
