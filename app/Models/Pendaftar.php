<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pendaftar extends Model
{
    protected $table = 'tabel_pendaftar';

    protected $primaryKey = 'id_pendaftar';

    protected $fillable = [
        'jenis_pendaftar',
        'tanggal_daftar',
        'tanggal_kunjungan',
        'nama',
        'nama_instansi',
        'alamat',
        'email',
        'tujuan_kunjungan',
        'surat_pengajuan',
        'jumlah_pengunjung',
        'status_pengajuan',
        'catatan_admin',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_pendaftar';
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'id_pendaftar', 'id_pendaftar');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id_pendaftar', 'id_pendaftar');
    }
}
