<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = ['name'];

    public $timestamps = false;

    public static $rules = [
        'name' => 'required|unique:departments|max:255',
    ];

    public function employes()
    {
        return $this->hasMany(Employe::class, 'department_id');
    }
}
