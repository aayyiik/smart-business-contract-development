<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Approval;
use App\Models\Contract;
use App\Models\ContractVendor;
use App\Models\ReviewLegal;
use App\Models\User;
use Carbon\Carbon;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\DNS2D;
use PhpOffice\PhpWord\TemplateProcessor;

use function Ramsey\Uuid\v1;

class VendorController extends Controller
{
    public function contracts()
    {
        $vendor = Vendor::where('user_detail_id', Auth::id())->first();
        $contracts = $vendor->contracts()->get();

        return view('vendor.contracts', compact('contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();

        return view('vendor.contract',  compact('contracts', 'contract', 'review_hukum'));
    }


    public function contract_edit(Contract $contract, Vendor $vendor)
    {
        $contracts = Contract::where('id', $contract->id)->first();
        $dateSPFormat = Carbon::createFromFormat('Y-m-d', $contracts->date_sp)->format('d-M-Y');

        $contract = $contracts->vendors()->where('vendor_id', $vendor->id)->first();
        return view('vendor.contract-edit', compact('contract','contracts','dateSPFormat'));
    }

    public function contract_update(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'prosentase' => 'required',
            'nilai_kontrak' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $fileName = now()->format('Ymd') . "_" .  Str::random(20);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 2,
            'number' => $request->number,
            'prosentase' => $request->prosentase,
            'nilai_kontrak' => $request->nilai_kontrak,
            'director' => $request->director,
            'phone' => $request->phone,
            'address' => $request->address,
            'filename' => $fileName,
        ]);

        //mengubah date ('Y-m-d') ke ('d-m-Y)
        $date_dof = Carbon::createFromFormat('Y-m-d', $request->date_dof)->format('d-m-Y');
        $date_sp = Carbon::createFromFormat('Y-m-d', $request->date_sp)->format('d-m-Y');
        $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('d-m-Y');
        $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('d-m-Y');

        // .docx
        $templateProcessor = new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');
        $templateProcessor->setValue('number', $request->number);
        $templateProcessor->setValue('date_dof', $date_dof);  
        $templateProcessor->setValue('date_name', $request->date_name);
        $templateProcessor->setValue('prosentase', $request->prosentase);
        $templateProcessor->setValue('nilai_kontrak', $request->nilai_kontrak);
        $templateProcessor->setValue('director', $request->director);
        $templateProcessor->setValue('vendor_upper', $request->vendor_upper);
        $templateProcessor->setValue('vendor_capital', $request->vendor_capital);
        $templateProcessor->setValue('phone', $request->phone);
        $templateProcessor->setValue('address', $request->address);
        $templateProcessor->setValue('no_sp', $request->no_sp);
        $templateProcessor->setValue('date_sp', $date_sp);
        $templateProcessor->setValue('start_rute', $request->start_rute);
        $templateProcessor->setValue('date_sname', $request->date_sname);
        $templateProcessor->setValue('end_rute', $request->end_rute);
        $templateProcessor->setValue('date_ename', $request->date_sname);
        $templateProcessor->setValue('start_date', $start_date);
        $templateProcessor->setValue('end_date', $end_date);
        $templateProcessor->setValue('delivery_date', $request->date_sname);
        $templateProcessor->setValue('name_devdate', $request->date_sname);
        $templateProcessor->setValue('state_rate', $request->state_rate);
        $templateProcessor->setValue('performance_bond', $request->performance_bond);
        $templateProcessor->setValue('terbilang_rupiah', $request->terbilang_rupiah);
        $templateProcessor->setValue('email', $request->email);
        $templateProcessor->setValue('place_vendor', $request->place_vendor);
        $templateProcessor->setValue('no_sp', $request->no_sp);
        $templateProcessor->setValue('date_sp', $date_sp);
        $templateProcessor->setValue('management_executives', $request->management_executives);
        $templateProcessor->setValue('management_job', $request->management_job);
        $templateProcessor->saveAs($fileName . '.docx');

        // .pdf
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save(public_path($fileName . '.pdf'));

        // .docx
        // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
        // $docxWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'Word2007');
        // $docxWriter->save(public_path($fileName . '.docx'));

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 1,
            'description' => 'Data Kontrak Diisi Oleh Vendor',
        ]);

        $flasher->addSuccess('Berhasil menambah data kontrak!');

        return redirect()->route('vendor.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
    }

    public function sign_contracts()
    {
        $vendor = Vendor::where('user_detail_id', Auth::id())->first();
        $contracts = $vendor->contracts()->where('status_id', [10])->get();
        // $sign = ContractVendor::whereIn('status_id', [10,11])->get();
        return view('vendor.sign-contracts', compact('contracts','vendor'));
    }

    public function sign_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        $path = Storage::url('gQU8ArBwT84xOuO9Rc2vFgPMlOR6GI.pdf');
        // return '<img src=*' . asset('/file_upload/gQU8ArBwT84xOuO9Rc2vFgPMlOR6GI.pdf'). '" alt=**>';

        return view('vendor.sign-contract', compact('contracts', 'contract'));
    }

    public function sign_contract_upload(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        $request->validate([
            'kontrak' => 'nullable|mimes:pdf|max:10000',
        ]);

        if ($request->hasFile('kontrak')) {
            $kontrak = $request->file('kontrak');
            $nama_kontrak = Str::random(30) . '.' . $kontrak->getClientOriginalExtension();
            $kontrak->move('file_upload', $nama_kontrak);
        }

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'final_vendor' => $nama_kontrak,
            'status_id' => 11
        ]);

      

        $flasher->addSuccess('Kontrak berhasil diupload!');

        return redirect()->back();
    }

    public function show_final(Contract $contract, Vendor $vendor)
    {

    }

    public function check_unique(Request $request)
    {
        $number = $request->input('number');

        // Periksa apakah email sudah ada di database
        $dof = ContractVendor::where('number', $number)->first();

        if ($dof) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
