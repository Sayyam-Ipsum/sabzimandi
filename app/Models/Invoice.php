<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id_fk', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id_fk');
    }
}
