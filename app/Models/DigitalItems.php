<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalItems extends Model
{
    use HasFactory;

    protected $table = 'digital_items';

    protected $fillable = [
        'transaction_item_id',
        'item_data',
        'delivery_date'
    ];
}
