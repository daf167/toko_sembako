<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'user_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'date',
        'item_code_snapshot',
        'item_name_snapshot',
        'category_name_snapshot',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
