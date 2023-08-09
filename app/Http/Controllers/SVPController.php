<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Approval;
use App\Models\Vendor;
use App\Models\ContractVendor;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;

class SVPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:SVP');
    }

    public function contracts()
    {
        $user_id = Auth::id();
        $contracts = ContractVendor::where('status_id', '>=', 7)->get();
        return view('svp.contracts', compact('user_id', 'contracts'));
    }

    public function contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $approvals = Approval::where('contract_vendor_id', $contracts->pivot->id)->orderBy('created_at', 'DESC')->get();

        return view('svp.contract', compact('contracts', 'contract', 'approvals'));
    }

    public function review_contracts()
    {
        $contracts = ContractVendor::whereIn('status_id', [7])->get();
        return view('svp.review-contracts', compact('contracts'));
    }

    public function review_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        return view('svp.review-contract', compact('contracts', 'contract'));
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

        return redirect()->route('svp.review-contracts');
    }

    //     public function contract_approval(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    //     {
    //         $request->validate([
    //             'description' => 'required'
    //         ]);

    //         $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

    //         Approval::create([
    //             'contract_vendor_id' => $contract_detail->pivot->id,
    //             'name' => Auth::user()->name,
    //             'status' => 7,
    //             'description' => $request->description,
    //         ]);


    //         if ($contract->oe < 500000000) {
    //             //mulai tambah qr code
    //             // Mendapatkan URL view tertentu yang ingin Anda jadikan konten QR code
    //             $qrCodeText = route('vp.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
    //             $qrCodeName = $contract->id . $vendor->id . '_qrcode';
    //             // Membuat QR Code nya
    //             $qrCodeImagePath = public_path($qrCodeName . '.png'); // Provide a proper path
    //             $this->generateQRCode($qrCodeText, $qrCodeImagePath);

    //             //
    //             //mulai update filename file
    //             $fileName = now()->format('Ymd') . "_approved_" .  Str::random(20);
    //             //mengubah date ('Y-m-d') ke ('d-m-Y)
    //             $date_dof = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->date_dof)->format('d-m-Y');
    //             $date_sp = Carbon::createFromFormat('Y-m-d', $contract->date_sp)->format('d-m-Y');
    //             $start_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->start_date)->format('d-m-Y');
    //             $end_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->end_date)->format('d-m-Y');

    //             // Daftar kolom dan nilai yang akan diubah
    //             $replaceValues = [
    //                 'no_dof' => $contract_detail->pivot->no_dof,
    //                 'date_dof' => $date_dof,
    //                 'date_name' => $contract_detail->pivot->date_name,
    //                 'prosentase' => $contract_detail->pivot->prosentase,
    //                 'management_executives' => $contract_detail->pivot->management_executives,
    //                 'management_job' => $contract_detail->pivot->management_job,
    //                 'vendor_upper' => $contract_detail->pivot->vendor_upper,
    //                 'vendor_capital' => $contract_detail->pivot->vendor_capital,
    //                 'director' => $contract_detail->pivot->director,
    //                 'phone' => $contract_detail->pivot->phone,
    //                 'address' => $contract_detail->pivot->address,
    //                 'email' => $contract_detail->pivot->email,
    //                 'place_vendor' => $contract_detail->pivot->place_vendor,
    //                 'contract_amount' => $contract_detail->pivot->contract_amount,
    //                 'state_rate' => $contract_detail->pivot->state_rate,
    //                 'minimum_transport' => $contract_detail->pivot->minimum_transport,
    //                 'start_date' => $start_date,
    //                 'date_sname' => $contract_detail->pivot->date_sname,
    //                 'end_date' => $end_date,
    //                 'date_ename' => $contract_detail->pivot->date_ename,
    //                 'performance_bond' => $contract_detail->pivot->performance_bond,
    //                 'rupiah' => $contract_detail->pivot->rupiah,
    //                 'delivery_date' => $contract_detail->pivot->delivery_date,
    //                 'name_devdate' => $contract_detail->pivot->name_devdate,
    //                 'no_sp' => $contract_detail->pivot->no_sp,
    //                 'date_sp' => $date_sp
    //             ];

    //             $imageReplacements = [
    //                 'qrcode' => $qrCodeImagePath
    //             ];

    //             // Mengganti nilai-nilai di template dengan loop foreach
    //             $templateProcessor = new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');
    //             foreach ($replaceValues as $field => $value) {
    //                 $templateProcessor->setValue($field, $value);
    //             }
    //             foreach ($imageReplacements as $imageField => $imagePath) {
    //                 $templateProcessor->setImageValue($imageField, ['qrcode' => asset($imagePath), 'width' => 200, 'height' => 100]);
    //             }

    //             // Simpan dokumen yang telah diperbarui
    //             $updatedFileName = $fileName . '.docx';
    //             $templateProcessor->saveAs($updatedFileName);
    //             // // .docx
    //             // $templateProcessor = new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');

    //             // // Path ke gambar yang ingin Anda sisipkan
    //             // $imagePath = (asset($qrCodeImagePath)); // Ganti dengan path gambar sesuai lokasi

    //             // $templateProcessor->setValue('no_dof', $contract_detail->pivot->no_dof);
    //             // $templateProcessor->setValue('date_dof', $date_dof);
    //             // $templateProcessor->setValue('date_name', $contract_detail->pivot->date_name);
    //             // $templateProcessor->setValue('prosentase', $contract_detail->pivot->prosentase);
    //             // $templateProcessor->setValue('management_executives', $contract_detail->pivot->management_executives);
    //             // $templateProcessor->setValue('management_job', $contract_detail->pivot->management_job);
    //             // $templateProcessor->setValue('vendor_upper', $contract_detail->pivot->vendor_upper);
    //             // $templateProcessor->setValue('vendor_capital', $contract_detail->pivot->vendor_capital);
    //             // $templateProcessor->setValue('director', $contract_detail->pivot->director);
    //             // $templateProcessor->setValue('phone', $contract_detail->pivot->phone);
    //             // $templateProcessor->setValue('address', $contract_detail->pivot->address);
    //             // $templateProcessor->setValue('email', $contract_detail->pivot->email);
    //             // $templateProcessor->setValue('place_vendor', $contract_detail->pivot->place_vendor);
    //             // $templateProcessor->setValue('contract_amount', $contract_detail->pivot->contract_amount);
    //             // $templateProcessor->setValue('state_rate', $contract_detail->pivot->state_rate);
    //             // $templateProcessor->setValue('minimum_transport', $contract_detail->pivot->minimum_transport);
    //             // $templateProcessor->setValue('start_date', $start_date);
    //             // $templateProcessor->setValue('date_sname', $contract_detail->pivot->date_sname);
    //             // $templateProcessor->setValue('end_date', $end_date);
    //             // $templateProcessor->setValue('date_ename', $contract_detail->pivot->date_ename);
    //             // $templateProcessor->setValue('performance_bond', $contract_detail->pivot->performance_bond);
    //             // $templateProcessor->setValue('rupiah', $contract_detail->pivot->rupiah);
    //             // $templateProcessor->setValue('delivery_date', $contract_detail->pivot->delivery_date);
    //             // $templateProcessor->setValue('name_devdate', $contract_detail->pivot->name_devdate);
    //             // $templateProcessor->setValue('no_sp', $contract_detail->pivot->no_sp);
    //             // $templateProcessor->setValue('date_sp', $date_sp);
    //             // $templateProcessor->setImageValue('qrcode', array('qrcode' => $imagePath, 'width' => 200, 'height' => 100));
    //             // $templateProcessor->saveAs($fileName . '.docx');

    //             // .pdf
    //             $domPdfPath = base_path('vendor/dompdf/dompdf');
    //             \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
    //             \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
    //             $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($fileName . '.docx'));
    //             $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
    //             $PDFWriter->save(public_path($fileName . '.pdf'));

    //             // update nama pdf
    //             $contract->vendors()->updateExistingPivot($vendor->id, [
    //                 'status_id' => 9,
    //                 'filename' => $fileName
    //             ]);

    //             $flasher->addSuccess('Draft Kontrak Approved!');
    //         } else {
    //             $contract->vendors()->updateExistingPivot($vendor->id, [
    //                 'status_id' => 8,
    //             ]);

    //             $flasher->addSuccess('Berhasil memproses lanjut!');
    //         }

    //         return redirect()->route('svp.review-contracts');
    //     }

        private function generateQRCode($text, $filename)
        {
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new ImagickImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrCode = $writer->writeString($text);

            // Save the QR code image to a file
            file_put_contents($filename, $qrCode);
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
            'status' => 7,
            'description' => $request->description,
        ]);

        if ($contract->oe < 500000000) {
            $qrCodeImagePath = $this->generateQRCodeImage($contract, $vendor);

            $fileName = $this->generateFileName();
            $date_dof = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->date_dof)->format('d-m-Y');
            $date_sp = Carbon::createFromFormat('Y-m-d', $contract->date_sp)->format('d-m-Y');
            $start_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->start_date)->format('d-m-Y');
            $end_date = Carbon::createFromFormat('Y-m-d', $contract_detail->pivot->end_date)->format('d-m-Y');

            $templateProcessor = $this->generateTemplateProcessor();

            $this->setValuesInTemplate($templateProcessor, $contract_detail, $date_dof, $date_sp, $start_date, $end_date);
            $this->setImageValueInTemplate($templateProcessor, 'qrcode', $qrCodeImagePath);

            $this->saveTemplateAsDocx($templateProcessor, $fileName);

            $this->convertDocxToPdf($fileName);

            $this->updateContractVendor($contract, $vendor, $fileName);

            $flasher->addSuccess('Draft Kontrak Approved!');
        } else {
            $this->updateContractVendor($contract, $vendor, null, 8);

            $flasher->addSuccess('Berhasil memproses lanjut!');
        }

        return redirect()->route('svp.review-contracts');
    }

    private function generateQRCodeImage(Contract $contract, Vendor $vendor)
    {
        $qrCodeText = route('vp.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
        $qrCodeName = $contract->id . $vendor->id . '_qrcode';
        $qrCodeImagePath = public_path($qrCodeName . '.png'); // Provide a proper path
        $this->generateQRCode($qrCodeText, $qrCodeImagePath);

        return $qrCodeImagePath;
    }

    private function generateFileName()
    {
        return now()->format('Ymd') . "approved" .  Str::random(20);
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

    private function setImageValueInTemplate($templateProcessor, $field, $imagePath)
    {
        $templateProcessor->setImageValue($field, ['qrcode' => asset($imagePath), 'width' => 200, 'height' => 100]);
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
        $updateData = ['status_id' => $statusId];
        if ($fileName !== null) {
            $updateData['filename'] = $fileName;
        }

        $contract->vendors()->updateExistingPivot($vendor->id, $updateData);
    }
}
