<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungan extends Model
{
    protected $table = 'tabel_kunjungan';

    protected $primaryKey = 'id_pengunjung';

    protected $fillable = [
        'tanggal_daftar',
        'tanggal_kunjungan',
        'nama',
        'nama_instansi',
        'email',
        'tujuan_kunjungan',
        'surat_pengajuan',
        'jumlah_pengunjung',
        'payment_method',
        'id_payment',
        'status_kunjungan',
        'qr_token',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'id_payment', 'id_payment');
    }
}
