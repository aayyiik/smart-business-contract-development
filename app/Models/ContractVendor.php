<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractVendor extends Model
{
    use HasFactory;

    protected $table = "contract_vendor";

    protected $fillable = ['id', 'contract_id', 'status_id', 'vendor_id', 'no_dof', 'date_dof', 'date_name', 'management_executives', 'management_job', 'vendor_upper', 'vendor_capital',  'director', 'address', 'phone', 'email', 'place_vendor', 'prosentase', 'contract_amount', 'state_rate', 'minimum_transport', 'date_sname', 'start_date', 'date_ename', 'end_date', 'performance_bond', 'rupiah', 'delivery_date', 'name_devdate', 'qrcode', 'filename', 'final_vendor'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function review()
    {
        return $this->hasMany(ReviewLegal::class, 'contract_vendor_id');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'contract_vendor_id');
    }
}
