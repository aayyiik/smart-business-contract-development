<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Approval;
use App\Models\Vendor;
use App\Models\ContractVendor;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;

;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Dompdf\Frame as DompdfFrame;
use Dompdf\FrameDecorator\Page;
use Dompdf\Options;
use Endroid\QrCode\Writer\Result\PngResult;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;
use Dompdf\Frame\Frame;
use Dompdf\Frame\Factory as FrameFactory;
use Dompdf\Canvas;
use PhpOffice\PhpWord\Style\Frame as StyleFrame;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007\Style\Frame as Word2007StyleFrame;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
use Fpdf\Fpdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\PDF\MPDF;
use PhpOffice\PhpWord\Writer\PDF\TCPDF;

use Endroid\QrCode\QrCode;

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

        // Mendapatkan URL view tertentu yang ingin Anda jadikan konten QR code
        $qrCodeText = route('vp.contract', ['contract' => $contract->id, 'vendor' => $vendor->id]);
        $qrCodeImagePath = public_path('qr_code.png'); // Provide a proper path

        $this->generateQRCode($qrCodeText, $qrCodeImagePath);

        // Pastikan file PDF ada sebelum melanjutkan
        $pdfPath = public_path($contracts->pivot->filename . '.pdf');
        if (!file_exists($pdfPath)) {
            abort(404, 'PDF not found');
        }

        // Load the existing PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfPath);

        // Render the PDF
        $dompdf->render();

        // Get the number of pages in the PDF
        $numPages = $dompdf->getCanvas()->get_page_count();

        // Add the QR code image to each page of the PDF
        for ($pageNum = 1; $pageNum <= $numPages; $pageNum++) {
            $qrCodeImgTag = '<img src="' . $qrCodeImagePath . '" style="position: absolute; top: 10px; left: 10px;" />';
            $dompdf->getCanvas()->page_text(10, 10, $qrCodeImgTag, null, 10, array(0, 0, 0));
        }

        // Output PDF to the browser
        $pdfContent = $dompdf->output();

        // Convert the PDF content to base64
        $pdfBase64 = base64_encode($pdfContent);

        // Output the view with the PDF content
        return view('vp.contract', compact('contracts', 'contract', 'approvals',  'pdfBase64'));

}

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

    public function review_contracts()
    {
        $contracts = ContractVendor::whereIn('status_id', [6])->get();
        return view('vp.review-contracts', compact('contracts'));
    }

    public function review_contract(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        // $qrcode = new Generator;
        // $qrcode->size(500)->generate('approved');

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
        $request->validate([
            'description' => 'required'
        ]);

        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 6,
            'description' => $request->description,
        ]);
       

       // dd($contract->oe);
        if ($contract->oe < 100000000) {
            $contract->vendors()->updateExistingPivot($vendor->id, [
                'status_id' => 9,
            ]);

            $flasher->addSuccess('Draft Kontrak Approved!');
        } else {
            $contract->vendors()->updateExistingPivot($vendor->id, [
                'status_id' => 7,
            ]);

            $flasher->addSuccess('Berhasil memproses lanjut!');
        }


        return redirect()->route('vp.review-contracts');
    }
}
