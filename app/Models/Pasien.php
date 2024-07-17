<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = ['id_user', 'name', 'age', 'phone', 'alamat'];
    public function penyakit()
    {
        return $this->hasMany(Penyakit::class);
    }
}
