<?php

namespace App\Models;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class penyakit extends Model
{
    use HasFactory;
    protected $table = "penyakits";
    protected $fillable = [
        'id_pasien',
        'bpm',
        'spo2',
        'gula_darah',
    ];
    protected $guarded = [];
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
}
