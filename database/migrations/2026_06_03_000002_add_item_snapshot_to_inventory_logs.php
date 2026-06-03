<?php

use App\Models\InventoryLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory_logs', 'item_code_snapshot')) {
                $table->string('item_code_snapshot')->nullable()->after('date');
            }

            if (! Schema::hasColumn('inventory_logs', 'item_name_snapshot')) {
                $table->string('item_name_snapshot')->nullable()->after('item_code_snapshot');
            }

            if (! Schema::hasColumn('inventory_logs', 'category_name_snapshot')) {
                $table->string('category_name_snapshot')->nullable()->after('item_name_snapshot');
            }
        });

        InventoryLog::with('item.category')
            ->whereNotNull('item_id')
            ->whereNull('item_name_snapshot')
            ->get()
            ->each(function (InventoryLog $log) {
                if (! $log->item) {
                    return;
                }

                $log->forceFill([
                    'item_code_snapshot' => $log->item->item_code,
                    'item_name_snapshot' => $log->item->name,
                    'category_name_snapshot' => $log->item->category?->name,
                ])->save();
            });
    }

    public function down(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('inventory_logs', 'category_name_snapshot') ? 'category_name_snapshot' : null,
                Schema::hasColumn('inventory_logs', 'item_name_snapshot') ? 'item_name_snapshot' : null,
                Schema::hasColumn('inventory_logs', 'item_code_snapshot') ? 'item_code_snapshot' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
