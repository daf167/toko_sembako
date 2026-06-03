<?php

use App\Models\InventoryLog;
use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory_logs', 'stock_before')) {
                $table->unsignedInteger('stock_before')->nullable()->after('quantity');
            }

            if (! Schema::hasColumn('inventory_logs', 'stock_after')) {
                $table->unsignedInteger('stock_after')->nullable()->after('stock_before');
            }
        });

        Item::with(['inventoryLogs' => fn ($query) => $query->orderBy('date')->orderBy('created_at')->orderBy('id')])
            ->get()
            ->each(function (Item $item) {
                $logs = $item->inventoryLogs;

                if ($logs->isEmpty()) {
                    return;
                }

                $netChange = $logs->sum(fn (InventoryLog $log) => $log->type === 'masuk' ? $log->quantity : -$log->quantity);
                $runningStock = max(0, $item->current_stock - $netChange);

                $logs->each(function (InventoryLog $log) use (&$runningStock) {
                    $before = $runningStock;
                    $after = $log->type === 'masuk'
                        ? $before + $log->quantity
                        : max(0, $before - $log->quantity);

                    $log->forceFill([
                        'stock_before' => $before,
                        'stock_after' => $after,
                    ])->save();

                    $runningStock = $after;
                });
            });
    }

    public function down(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('inventory_logs', 'stock_after') ? 'stock_after' : null,
                Schema::hasColumn('inventory_logs', 'stock_before') ? 'stock_before' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
