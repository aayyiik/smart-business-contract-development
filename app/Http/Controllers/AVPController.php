<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Contract;
use App\Models\Vendor;
use App\Models\ContractVendor;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AVPController extends Controller
{
    public function contracts()
    {
        $user_id = Auth::id();
        $contracts = ContractVendor::where('status_id', '>=', 5)->get();
        return view('avp.contracts', compact('user_id', 'contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $approvals = Approval::where('contract_vendor_id', $contracts->pivot->id)->orderBy('created_at', 'DESC')->get();

        return view('avp.contract', compact('contracts', 'contract', 'approvals'));
    }

    public function review_contracts()
    {
        $contracts = ContractVendor::whereIn('status_id', [5])->get();
        return view('avp.review-contracts', compact('contracts'));
    }

    public function review_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        return view('avp.review-contract', compact('contracts', 'contract'));
    }

    public function contract_return(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 5,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 2,
        ]);

        $flasher->addSuccess('Berhasil mengembalikan!');

        return redirect()->route('avp.review-contracts');
    }

    public function contract_approval(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 5,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 6,
        ]);

        $flasher->addSuccess('Berhasil memproses lanjut!');

        return redirect()->route('avp.review-contracts');
    }
}
