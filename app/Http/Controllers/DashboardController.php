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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $user = User::find(auth()->user()->id);
        $vendorId = Auth::user()->userDetail->vendor_id;

        $active_tender = DB::table('contract_vendor as a')
            ->join('contracts as b', 'a.contract_id', '=', 'b.id')
            ->join('user_details as c', 'b.user_detail_id', '=', 'c.id')
            ->where('a.status_id', '>=', 1)
            ->where('a.status_id', '<=', 10)
            ->where('a.vendor_id', $vendorId)
            ->count();


        $sign_vendor = DB::table('contract_vendor as a')
            ->join('contracts as b', 'a.contract_id', '=', 'b.id')
            ->join('user_details as c', 'b.user_detail_id', '=', 'c.id')
            ->where('a.status_id', '=', 10)
            ->where('a.vendor_id', $vendorId)
            ->count();

        $final_vendor = DB::table('contract_vendor as a')
            ->join('contracts as b', 'a.contract_id', '=', 'b.id')
            ->join('user_details as c', 'b.user_detail_id', '=', 'c.id')
            ->where('a.status_id', '>=', 11)
            ->where('a.vendor_id', $vendorId)
            ->count();

        $review = DB::table('contract_vendor as a')
            ->join('contracts as b', 'a.contract_id', '=', 'b.id')
            ->join('user_details as c', 'b.user_detail_id', '=', 'c.id')
            ->where('a.status_id', '=', 1)
            ->where('a.vendor_id', $vendorId)
            ->count();

        //AVP
        $avpUnitId = Auth::user()->userDetail->unit_id;

        $review_avp = ContractVendor::whereHas('contract.userDetail', function ($query) use ($avpUnitId) {
            $query->where('unit_id', $avpUnitId)->where('status_id', '=', 5);
        })->count();

        $contracts_avp = ContractVendor::whereHas('contract.userDetail', function ($query) use ($avpUnitId) {
            $query->where('unit_id', $avpUnitId)->where('status_id', '>=', 5);
        })->count();

        //VP
        $review_vp = ContractVendor::where('status_id', '=', 6)->count();
        $contracts_vp = DB::table('contract_vendor as a')
        ->join('contracts as b', 'a.contract_id', '=', 'b.id')
        ->where('a.status_id', '>=', 6)
        ->where('b.oe', '<', 100000000)
        ->count();

        //SVP
        $review_svp = ContractVendor::where('status_id', '=', 7)->count();
        $contracts_svp = DB::table('contract_vendor as a')
        ->join('contracts as b', 'a.contract_id', '=', 'b.id')
        ->where('a.status_id', '>=', 7)
        ->whereBetween('b.oe', [100000000, 500000000])
        ->count();

        //DKU
        $review_dku = ContractVendor::where('status_id', '=', 8)->count();
        $contracts_dku = DB::table('contract_vendor as a')
        ->join('contracts as b', 'a.contract_id', '=', 'b.id')
        ->where('a.status_id', '>=', 8)
        ->where('b.oe', '>', 500000000)
        ->count();


        return view('dashboard',compact(
            'contract',
            'review_vendor', 
            'approval', 
            'review_hukum', 
            'final', 
            'users', 
            'units', 
            'departments',
            'roles',
            'vendors', 
            'templates',
            'statuses', 
            'active_tender',
            'sign_vendor',
            'final_vendor',
            'review', 
            'contracts_avp',
            'review_avp',
            'contracts_vp',
            'review_vp',
            'contracts_svp',
            'review_svp',
            'contracts_dku',
            'review_dku'));
    }
}
