<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topic extends Model
{
    use HasFactory;
    protected $table = "topics";
    protected $fillable = [
        'instansi',
        'topic_pub',
        'topic_sub',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id_topic', 'id');
    }
}
