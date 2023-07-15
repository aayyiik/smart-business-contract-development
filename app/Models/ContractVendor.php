<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractVendor extends Model
{
    use HasFactory;

    protected $table = "contract_vendor";

    protected $fillable = ['id', 'contract_id', 'status_id', 'vendor_id', 'number', 'prosentase', 'nilai_kontrak', 'director', 'address', 'phone', 'filename', 'final_vendor', 'created_at', 'updated_at'];

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
