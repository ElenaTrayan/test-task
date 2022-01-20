<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = ['name'];

    public $timestamps = false;

    public static $rules = [
        'name' => 'required|unique:positions|max:255',
    ];

    public function employes()
    {
        return $this->hasMany(Employe::class, 'position_id');
    }
}
