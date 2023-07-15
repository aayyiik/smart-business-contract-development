<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $table = "approvals";

    protected $fillable = ['id', 'contract_vendor_id', 'name', 'status', 'description', 'created_at', 'updated_at'];

    public function contractVendor()
    {
        return $this->belongsTo(ContractVendor::class, 'contract_vendor_id');
    }
}
