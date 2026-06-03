<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE inventory_logs DROP FOREIGN KEY inventory_logs_item_id_foreign');
        DB::statement('ALTER TABLE inventory_logs MODIFY item_id CHAR(36) NULL');
        DB::statement('ALTER TABLE inventory_logs ADD CONSTRAINT inventory_logs_item_id_foreign FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('DELETE FROM inventory_logs WHERE item_id IS NULL');
        DB::statement('ALTER TABLE inventory_logs DROP FOREIGN KEY inventory_logs_item_id_foreign');
        DB::statement('ALTER TABLE inventory_logs MODIFY item_id CHAR(36) NOT NULL');
        DB::statement('ALTER TABLE inventory_logs ADD CONSTRAINT inventory_logs_item_id_foreign FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE');
    }
};
