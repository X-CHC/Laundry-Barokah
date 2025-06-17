<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'tbl_layanan';
    protected $primaryKey = 'id_layanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_layanan',
        'nama_layanan',
        'deskripsi',
        'harga_per_kg',
        'estimasi_durasi',
        'status_layanan',
    ];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
    ];
}