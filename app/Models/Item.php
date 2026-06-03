<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category_id',
        'item_code',
        'name',
        'current_stock',
        'lowest_stock_threshold',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Item $item) {
            $item->status = (int) $item->current_stock === 0 ? 'tidak tersedia' : 'tersedia';
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}
