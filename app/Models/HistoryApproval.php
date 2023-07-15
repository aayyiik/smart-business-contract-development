<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryApproval extends Model
{
    use HasFactory;

    protected $table = "history_approval";

    protected $fillable = ['id', 'contractvendor_id', 'user_id', 'status_id', 'notes', 'created_at', 'updated_at'];
}
