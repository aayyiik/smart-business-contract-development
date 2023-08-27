<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = "contracts";

    protected $fillable = ['id', 'user_detail_id', 'template_id', 'name', 'oe', 'no_sp', 'date_sp', 'created_at', 'updated_at'];

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
        return $this->belongsToMany(Vendor::class)->withPivot('status_id', 'no_dof', 'date_dof', 'date_name', 'management_executives', 'management_job', 'vendor_upper', 'vendor_capital',  'director', 'address', 'phone', 'email', 'place_vendor', 'prosentase', 'contract_amount', 'state_rate', 'minimum_transport', 'date_sname', 'start_date', 'date_ename', 'end_date', 'performance_bond', 'rupiah', 'delivery_date', 'name_devdate', 'qrcode', 'filename', 'final_vendor');
    }

    public function contractVendor()
    {
        return $this->hasMany(ContractVendor::class, 'contract_id');
    }
}
