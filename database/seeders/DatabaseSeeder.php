<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Administrator', 'email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Staff Inventory', 'email' => 'staff@example.com', 'password' => 'password', 'role' => 'staff']);
        User::create(['name' => 'Owner', 'email' => 'owner@example.com', 'password' => 'password', 'role' => 'owner']);

        $beras = Category::create(['name' => 'Beras', 'description' => 'Produk beras kemasan dan curah']);
        $minyak = Category::create(['name' => 'Minyak Goreng', 'description' => 'Produk minyak goreng harian']);

        Item::create(['category_id' => $beras->id, 'item_code' => 'BRS-001', 'name' => 'Beras Premium 5kg', 'current_stock' => 25, 'lowest_stock_threshold' => 10]);
        Item::create(['category_id' => $minyak->id, 'item_code' => 'MYK-001', 'name' => 'Minyak Goreng 1L', 'current_stock' => 8, 'lowest_stock_threshold' => 10]);
    }
}
