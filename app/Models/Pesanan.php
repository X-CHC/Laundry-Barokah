<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{

    
    protected $table = 'tbl_pesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $casts = [
        'status' => 'string',
        'tglPengambilan' => 'date',
        'created_at' => 'datetime'
    ];
    
    protected $fillable = [
        'id_customer',
        'id_layanan',
        'jumlah',
        'price',
        'catatan',
        'metode_pembayaran',
        'bukti_bayar',
        'tglPengambilan',
        'status',
        'created_at'
    ];
    
    protected $dates = ['tglPengambilan', 'created_at'];

    
    
    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Auto-generate ID jika kosong
            if (empty($model->id_pesanan)) {
                $prefix = 'ORD'; // Prefix untuk ID Pesanan
                $lastOrder = self::orderBy('id_pesanan', 'desc')->first();
                
                if ($lastOrder) {
                    $lastNumber = (int) str_replace($prefix, '', $lastOrder->id_pesanan);
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }
                
                $model->id_pesanan = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}