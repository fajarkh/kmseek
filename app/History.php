<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**
     * @var string
     */
    protected $table = 'history';

    /**
     * @var array
     */
    protected $fillable = [
        'judul_history', 'konten','id_kategori','gambar_path','gambar_name',
    ];
}