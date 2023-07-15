<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $table = "templates";

    protected $fillable = ['id', 'template', 'unit', 'created_at', 'updated_at'];

    public function contract()
    {
        return $this->hasMany(Contract::class, 'template_id');
    }
}
