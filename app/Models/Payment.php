<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $table = 'tabel_payment';

    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'id_pendaftar',
        'payment_method',
        'status',
        'total',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_payment';
    }

    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class, 'id_pendaftar', 'id_pendaftar');
    }

    public function kunjungan(): HasOne
    {
        return $this->hasOne(Kunjungan::class, 'id_payment', 'id_payment');
    }
}
