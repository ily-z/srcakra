<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisableDay extends Model
{
    protected $table = 'tabel_disable_day';

    protected $primaryKey = 'id_disday';

    protected $fillable = [
        'tanggal',
        'keterangan',
    ];
}
