<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'tbl_customer';
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';
    public $incrementing = false; 
    public $timestamps = true; 
    

    protected $fillable = [
        'id_customer',
        'username',
        'password',
        'email',
        'nama_panjang',
        'tlp',
        'alamat'

    ];

    protected $hidden = [
        'password',
    ];

    public function orders()
    {
        return $this->hasMany(Pesanan::class, 'id_customer', 'id_customer');
    }

    // ✅ Auto-generate ID
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->id_customer)) {
            $lastId = self::orderBy('id_customer', 'desc')->first()?->id_customer;
            $number = $lastId ? (int) str_replace('CTR', '', $lastId) + 1 : 1;
            $model->id_customer = 'CTR' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }
    });
}
}