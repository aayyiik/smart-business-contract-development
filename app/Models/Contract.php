<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = "contracts";

    protected $fillable = ['id', 'user_detail_id', 'template_id', 'name', 'oe', 'created_at', 'updated_at'];

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'user_detail_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class)->withPivot('number', 'prosentase', 'nilai_kontrak', 'director', 'address', 'phone', 'filename', 'final_vendor', 'status_id');
    }

    public function contractVendor()
    {
        return $this->hasMany(ContractVendor::class, 'contract_id');
    }
}
