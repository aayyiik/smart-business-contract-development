<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractVendor;
use App\Models\Departement;
use App\Models\Role;
use App\Models\Status;
use App\Models\Template;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function dashboard(Contract $contract, Vendor $vendor){
        //Super Admin
        $users = User::all()->count();
        $units = Unit::all() ->count();
        $departments = Departement::all()->count();
        $roles = Role::all()->count();
        $vendors = Vendor::all()->count();
        $templates = Template::all()->count();
        $statuses = Status::all()->count();

        //Buyer
        $contract = ContractVendor::all()->count();
        $review_vendor = ContractVendor::where('status_id','=','2')->get()->count();
        $review_hukum = ContractVendor::where('status_id','=','3')->get()->count();
        $approval = ContractVendor::where('status_id','=','5,6,7,8')->get()->count();
        $final = ContractVendor::where('status_id','=','11,12')->get()->count();

        //Vendor

        // $active_tender = ContractVendor::where('vendor_id',  auth()->user()->userDetail->vendor->id)->get()->count();
        $user = User::find(auth()->user()->id);
        $vendorId = $user->vendor_id;

        $active_tender = ContractVendor::whereHas('vendor', function ($query) use ($vendorId) {
            $query->where('id', $vendorId);
        })->count();
        $sign_vendor = ContractVendor::whereHas('vendor', function ($query) use ($vendorId) {
            $query->where('id', $vendorId)->where('status_id','10');
        })->get()->count();
        $final_vendor = ContractVendor::whereHas('vendor', function ($query) use ($vendorId) {
            $query->where('id', $vendorId)->where('status_id','11,12');
        })->get()->count();
        $review = ContractVendor::whereHas('vendor', function ($query) use ($vendorId) {
            $query->where('id', $vendorId)->where('status_id','1');
        })->get()->count();

        return view('dashboard',compact('contract','review_vendor', 'approval', 'review_hukum', 'final', 'users', 'units', 'departments','roles',
        'vendors', 'templates','statuses', 'active_tender','sign_vendor','final_vendor','review'));
    }
}
