<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = "units";

    protected $fillable = ['id', 'unit', 'created_at', 'updated_at'];
    public $timestamps = true;
    public function userDetail()
    {
        return $this->hasMany(UserDetail::class, 'unit_id');
    }
}
