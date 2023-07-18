<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = "user_details";

    protected $fillable = ['id', 'user_id', 'role_id', 'unit_id', 'department_id', 'email', 'phone', 'created_at', 'updated_at'];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'vendor_id');
    }

    public function contract()
    {
        return $this->hasMany(Contract::class, 'contract_id');
    }
}
