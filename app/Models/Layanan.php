<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'tbl_layanan';
    protected $primaryKey = 'id_layanan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_layanan',
        'nama_layanan',
        'deskripsi',
        'harga_per_kg',
        'estimasi_durasi',
        'status_layanan'
    ];

    protected $attributes = [
        'status_layanan' => 'aktif' // Default value
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_layanan)) {
                $lastId = self::orderBy('id_layanan', 'desc')->first()?->id_layanan;
                $number = $lastId ? (int) str_replace('LYN', '', $lastId) + 1 : 1;
                $model->id_layanan = 'LYN' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
            
            // Force status to aktif
            $model->status_layanan = 'aktif';
        });
    }
}