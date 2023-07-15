<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $table = "departments";

    protected $fillable = ['id', 'department', 'created_at', 'updated_at'];

    public function userDetail()
    {
        return $this->hasMany(UserDetail::class, 'department_id');
    }
}
