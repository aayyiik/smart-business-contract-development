<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Vendor;
use App\Models\ContractVendor;
use App\Models\ReviewLegal;
use App\Models\Approval;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;

class LegalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Legal');
    }

    //Menu Monitoring Contract
    public function contracts()
    {
        $contracts = ContractVendor::where('status_id', '>=', 3)->get();
        return view('legal.contracts', compact('contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();
        return view('legal.contract', compact('contracts', 'contract', 'review_hukum'));
    }

    //Menu Review Cotract
    public function review_contracts()
    {
        $contracts = ContractVendor::whereIn('status_id', [3])->get();
        return view('legal.contracts-review', compact('contracts'));
    }

    public function review_contract(Contract $contract, Vendor $vendor){
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();
        return view('legal.contract-review', compact('contracts', 'contract', 'review_hukum'));
    }
   
    public function contract_approval(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // validate input
        $request->validate([
            'review_contract' => 'required'
        ]);

        if($request->has('process')){
            // get contract_detail id
            $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

            // create approval
            Approval::create([
                'contract_vendor_id' => $contract_detail->pivot->id,
                'name' => Auth::user()->name,
                'status' => 3,
                'description' => 'Diproses oleh Hukum',
            ]);

            // create review
            $reviews = ReviewLegal::create([
                'contract_vendor_id' => $contract_detail->pivot->id,
                'name' => Auth::user()->name,
                'review_contract' => $request->review_contract,
            ]);

            ContractVendor::where('contract_id', $contract->id)->where('vendor_id', $vendor->id)
                ->update([
                    'status_id' => 4,
                ]);

            $flasher->addSuccess('Berhasil memproses lanjut!');

        }elseif($request->has('return')){
            // get contract_detail id
            $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

            // create approval
            Approval::create([
                'contract_vendor_id' => $contract_detail->pivot->id,
                'name' => Auth::user()->name,
                'status' => 3,
                'description' => 'Diproses oleh Hukum',
            ]);

            // create review
            $reviews = ReviewLegal::create([
                'contract_vendor_id' => $contract_detail->pivot->id,
                'name' => Auth::user()->name,
                'review_contract' => $request->review_contract,
            ]);

            ContractVendor::where('contract_id', $contract->id)->where('vendor_id', $vendor->id)
            ->update([
                'status_id' => 2,
            ]);

            $flasher->addSuccess('Berhasil mengembalikan draft kontrak!');
        }


        return redirect()->route('legal.review-contracts');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   

}
