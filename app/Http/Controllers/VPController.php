<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Approval;
use App\Models\Vendor;
use App\Models\ContractVendor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;

class VPController extends Controller
{
    public function contracts()
    {
        $user_id = Auth::id();
        $contracts = ContractVendor::where('status_id', '>=', 6)->get();
        return view('vp.contracts', compact('user_id', 'contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $approvals = Approval::where('contract_vendor_id', $contracts->pivot->id)->orderBy('created_at', 'DESC')->get();
        // Output the view with the PDF content
        return view('vp.contract', compact('contracts', 'contract', 'approvals'));
    }

    public function review_contracts()
    {
        $contracts = ContractVendor::whereIn('status_id', [6])->get();
        return view('vp.review-contracts', compact('contracts'));
    }

    public function review_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        return view('vp.review-contract', compact('contracts', 'contract'));
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
            'status' => 2,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 2,
        ]);

        $flasher->addSuccess('Berhasil mengembalikan!');

        return redirect()->route('vp.review-contracts');
    }


    public function contract_approval(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {

        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 6,
            'description' => $request->description,
        ]);

        if ($contract->oe < 100000000) {

            $fileName = $this->generateFileName();
            $date_dof = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->date_dof)->format('d-m-Y');
            $date_sp = Carbon::createFromFormat('Y-m-d', $contract->date_sp)->format('d-m-Y');
            $start_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->start_date)->format('d-m-Y');
            $end_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->end_date)->format('d-m-Y');

            $templateProcessor = $this->generateTemplateProcessor();

            $this->setValuesInTemplate($templateProcessor, $contract_detail, $date_dof, $date_sp, $start_date, $end_date);

            // Generate QR Code data
            $qrCodeData = $this->generateQRCode($contract, $vendor);

            $this->setImageValueInTemplate($templateProcessor, 'qrcode', $qrCodeData);

            $this->saveTemplateAsDocx($templateProcessor, $fileName);

            $this->convertDocxToPdf($fileName);

            $this->updateContractVendor($contract, $vendor, $fileName);

            $flasher->addSuccess('Draft Kontrak Approved!');

            return redirect()->route('vp.review-contracts');
        } else {
            $this->updateContractVendor($contract, $vendor, null, 7);

            $flasher->addSuccess('Berhasil memproses lanjut!');
        }

        return redirect()->route('vp.review-contracts');
    }


    private function generateQRCode($contract, $vendor)
    {
        $qrCodeText = route('vp.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeText);
        $qrCodeData = 'data:image/png;base64,' . base64_encode($qrCode);

        return $qrCodeData;
    }
    private function generateFileName()
    {
        return now()->format('Ymd') . "_approved_" .  Str::random(20);
    }

    private function generateTemplateProcessor()
    {
        return new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');
    }

    private function setValuesInTemplate($templateProcessor, $contract_detail, $date_dof, $date_sp, $start_date, $end_date)
    {
        $replaceValues = [
            'no_dof' => $contract_detail->pivot->no_dof,
            'date_dof' => $date_dof,
            'date_name' => $contract_detail->pivot->date_name,
            'prosentase' => $contract_detail->pivot->prosentase,
            'management_executives' => $contract_detail->pivot->management_executives,
            'management_job' => $contract_detail->pivot->management_job,
            'vendor_upper' => $contract_detail->pivot->vendor_upper,
            'vendor_capital' => $contract_detail->pivot->vendor_capital,
            'director' => $contract_detail->pivot->director,
            'phone' => $contract_detail->pivot->phone,
            'address' => $contract_detail->pivot->address,
            'email' => $contract_detail->pivot->email,
            'place_vendor' => $contract_detail->pivot->place_vendor,
            'contract_amount' => $contract_detail->pivot->contract_amount,
            'state_rate' => $contract_detail->pivot->state_rate,
            'minimum_transport' => $contract_detail->pivot->minimum_transport,
            'start_date' => $start_date,
            'date_sname' => $contract_detail->pivot->date_sname,
            'end_date' => $end_date,
            'date_ename' => $contract_detail->pivot->date_ename,
            'performance_bond' => $contract_detail->pivot->performance_bond,
            'rupiah' => $contract_detail->pivot->rupiah,
            'delivery_date' => $contract_detail->pivot->delivery_date,
            'name_devdate' => $contract_detail->pivot->name_devdate,
            'no_sp' => $contract_detail->pivot->no_sp,
            'date_sp' => $date_sp
        ];

        foreach ($replaceValues as $field => $value) {
            $templateProcessor->setValue($field, $value);
        }

        // Set date values
        $templateProcessor->setValue('date_dof', $date_dof);
        $templateProcessor->setValue('date_sp', $date_sp);
        $templateProcessor->setValue('start_date', $start_date);
        $templateProcessor->setValue('end_date', $end_date);
    }

    private function setImageValueInTemplate($templateProcessor, $field, $qrCodeData)
    {
        $templateProcessor->setImageValue($field, ['qrcode' => $qrCodeData, 'width' => 100, 'height' => 50]);
    }

    private function saveTemplateAsDocx($templateProcessor, $fileName)
    {
        $templateProcessor->saveAs($fileName . '.docx');
    }

    private function convertDocxToPdf($fileName)
    {
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save(public_path($fileName . '.pdf'));
    }

    private function updateContractVendor($contract, $vendor, $fileName = null, $statusId = 9)
    {
        //update status dan filename menjadi file yang sudah terapprover
        // $updateData = ['status_id' => $statusId];
        // if ($fileName !== null) {
        //     $updateData['filename'] = $fileName;
        // }

        // $contract->vendors()->updateExistingPivot($vendor->id, $updateData);

        // update status dan menambahkan data qrcode, namun filename tidak keubah 
        // 3 file akan terpenuhi pada tabel contract vendor. 
        $updateData = ['status_id' => $statusId];
        if ($fileName !== null) {
            $updateData['qrcode'] = $fileName;
        }

        $contract->vendors()->updateExistingPivot($vendor->id, $updateData);
    }
}
