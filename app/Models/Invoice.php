<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id_fk', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_fk');
    }
}
