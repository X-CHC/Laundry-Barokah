<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'tbl_admin';
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'nama_admin',
        'username_admin', 
        'password_admin'
    ];

    // Jika kolom password tidak menggunakan nama default 'password'
    public function getAuthPassword()
    {
        return $this->password_admin;
    }
}