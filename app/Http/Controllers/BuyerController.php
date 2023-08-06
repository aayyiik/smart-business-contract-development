<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Contract;
use App\Models\ContractVendor;
use App\Models\ReviewLegal;
use Flasher\Prime\FlasherInterface;
use App\Models\Vendor;
use App\Models\Template;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Milon\Barcode\DNS2D;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View as ViewView;
use SimpleSoftwareIO\QrCode\Facades\QrCode;




class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Buyer');
    }

    // CONTRACT MONITORING
    public function contracts_monitoring()
    {
        return view('buyer.contracts-monitoring', [
            "contracts" => Contract::where('user_detail_id', Auth::id())->get()
        ]);
    }

    public function contract_monitoring(Contract $contract)
    {
        $contract_vendor = $contract->vendors()->get();
        return view('buyer.contract-monitoring', compact('contract', 'contract_vendor'));
    }

    public function contract_monitoring_create()    
    {
        return view('buyer.contract-create', [
            "vendor" => Vendor::all(),
            "templates" => Template::all(),
        ]);
    }

    public function contract_monitoring_store(Request $request, FlasherInterface $flasher)
    {
        $request->validate([
            'name' => 'required|max:255',
            'oe' => 'required|numeric',
            'no_sp' => 'required',
            'date_sp' => 'required|date',
            'template_id' => 'required',
            'vendor_id' => 'required',
            'prosentase' => "required",
        ]);

        $data = $request->all();
        $contract = new Contract;
        $contract->name = $data['name'];
        $contract->oe = $data['oe'];
        $contract->user_detail_id = Auth::user()->id;
        $contract->template_id = $data['template_id'];
        $contract->no_sp = $data['no_sp'];
        $contract->date_sp = date('Y-m-d', strtotime($data['date_sp']));
        $contract->save();

        $vendorIds = $request->vendor_id;
        $prosentase = $request->prosentase;
        if (!is_null($vendorIds) && !is_null($prosentase) && count($vendorIds) === count($prosentase)) {
            foreach ($vendorIds as $item => $value) {
                $data2 = array(
                    'contract_id' => $contract->id,
                    'vendor_id' => $vendorIds[$item],
                    'prosentase'=> $prosentase[$item],
                    'status_id' => 1,
                );
                ContractVendor::create($data2);
            }
        }

        // method lama
        // $contract = Contract::create([
        //     'name' => $request->name,
        //     'oe' => $request->oe,
        //     'no_sp' => $request->no_sp,
        //     'date_sp' => $request->date_sp,
        //     'user_detail_id' => Auth::user()->id,
        //     'template_id' => $request->template_id,
        // ]);

        // $contract->vendors()->attach($request->vendor, ["status_id" => 1]);

        $flasher->addSuccess('Berhasil menambahkan pekerjaan!');

        return redirect()->route('buyer.contracts-monitoring');
    }

    public function contract_detail(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();
        $approvals = Approval::where('contract_vendor_id', $contracts->pivot->id)->orderBy('created_at', 'DESC')->get();

        return view('buyer.contract-detail', compact('contracts', 'contract', 'review_hukum', 'approvals'));
    }

    public function contract_edit(Contract $contract, Vendor $vendor)
    {
        $contracts = Contract::where('id', $contract->id)->first();
        $contract = $contracts->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        return view('buyer.contract-edit', compact('contract','contracts'));
    }

    public function contract_update(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // $request->validate([
        //     'number' => 'required',
        //     'prosentase' => 'required',
        //     'nilai_kontrak' => 'required',
        //     'director' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        // ]);

        // $template = Template::all();

        $fileName = now()->format('Ymd') . "_" .  Str::random(20);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 2,
            'number' => $request->number,
            'prosentase' => $request->prosentase,
            'director' => $request->director,
            'phone' => $request->phone,
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
        // $templateProcessor = new TemplateProcessor('word-template/template-kontrak-jasa-angkutan-darat.docx');
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

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 1,
            'description' => 'Data Kontrak Diisi Oleh Buyer',
        ]);

        $flasher->addSuccess('Berhasil mengubah data kontrak!');

        return redirect()->route('buyer.contract-detail', ['contract' => $contract->id, 'vendor' => $vendor->id]);
    }

    public function contract_delete(Contract $contract, FlasherInterface $flasher)
    {
        $contracts = Contract::find($contract->id);
        $contracts->delete($contracts);

        $flasher->addSuccess('Berhasil mengahapus data kontrak!');

        return redirect()->route('buyer.contracts-monitoring');
    }


    // CONTRACT REVIEW VENDOR
    public function contracts_review_vendor()
    {
        $contracts = ContractVendor::whereIn('status_id', [2])->get();
        return view('buyer.contracts-review-vendor', compact('contracts'));
    }

    public function contract_review_vendor(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        return view('buyer.contract-review-vendor', compact('contracts', 'contract'));
    }

    public function contract_review_vendor_return(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // validate input
        $request->validate([
            'description' => 'required'
        ]);

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 2,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 1,
        ]);

        $flasher->addSuccess('Berhasil mengembalikan ke vendor!');

        return redirect()->back();
    }

    public function contract_review_vendor_review(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // validate input
        $request->validate([
            'description' => 'required'
        ]);

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 2,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 3,
        ]);

        $flasher->addSuccess('Berhasil mengajukan review ke hukum!');

        return redirect()->back();
    }

    // CONTRACT REVIEW HUKUM
    public function contracts_review_legal()
    {
        $contracts = ContractVendor::whereIn('status_id', [3, 4])->get();
        return view('buyer.contracts-review-legal', compact('contracts'));
    }

    public function contract_review_legal(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();
        return view('buyer.contract-review-legal', compact('contracts', 'contract', 'review_hukum'));
    }

    public function contract_vendor_avp(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // validate input
        $request->validate([
            'description' => 'required'
        ]);

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 2,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 5,
        ]);

        $flasher->addSuccess('Berhasil mengajukan permintaan persetujuan ke AVP!');

        return redirect()->back();
    }

    // CONTRACT Approval
    public function contracts_approval()
    {
        $contracts = ContractVendor::whereIn('status_id', [4, 5, 6, 7, 8, 9])->get();
        return view('buyer.contracts-approval', compact('contracts'));
    }

    public function contract_approval(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();
        return view('buyer.contract-approval', compact('contracts', 'contract', 'review_hukum'));
    }

    public function contract_send(Request $request, Contract $contract, Vendor $vendor, FlasherInterface $flasher)
    {
        // validate input
        $request->validate([
            'description' => 'required'
        ]);

        // get contract_detail id
        $contract_detail = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();

        // create approval
        Approval::create([
            'contract_vendor_id' => $contract_detail->pivot->id,
            'name' => Auth::user()->name,
            'status' => 9,
            'description' => $request->description,
        ]);

        $contract->vendors()->updateExistingPivot($vendor->id, [
            'status_id' => 10,
        ]);

        $flasher->addSuccess('Berhasil mengirim ke rekanan!');

        return redirect()->back();
    }

    // CONTRACT FINAL
    public function contracts_final()
    {
        $contracts = ContractVendor::whereIn('status_id', [11])->get();
        return view('buyer.contracts-final', compact('contracts'));
    }

    public function contract_final(Contract $contract, Vendor $vendor)
    {
        $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
        $review_hukum = ReviewLegal::where('contract_vendor_id', $contracts->pivot->id)->get();

        // $url = 'https://sangcahaya.id';
        // $qr = DNS2D::getBarcodePNGPath($url, 'QRCODE');

        // $renderer = new ImageRenderer(
        //     new RendererStyle(400),
        //     new ImagickImageBackEnd()
        // );

        // $renderer = new ImageRenderer(
        //     new RendererStyle(400)
        // );
        // $writer = new Writer($renderer);
        // $qrCode = $writer->writeFile('Hello World!', 'qrcode.png');

        $qrcode = QrCode::size(300)->generate(route('buyer.contract-final', ['contract' => $contract->id, 'vendor' => $vendor->id]));
        return view('buyer.contract-final', compact('contracts', 'contract', 'review_hukum', 'qrcode'));
    }

    public function generatePdf()
{ 
    // $contracts = $contract->vendors()->where('vendor_id', $vendor->id)->withPivot('id')->first();
    // $data = ContractVendor::all(); // Replace with your data retrieval logic

    $data = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'address' => '123 Main St',
        ],
        [
            'id' => 2,
            'name' => 'Jane Smith',
            'address' => '456 Elm St',
        ],
    ];

    // Generate the QR code
    $url = route('generate-pdf');
    $qrCode = QrCode::size(600)->generate($url);

    // Generate the PDF
    $pdf = new Dompdf();
    $view = view('pdf-view', compact('data', 'qrCode'));
    $html = $view->render();
    $pdf->loadHtml($html);

    dd($html);
    // return $pdf->stream('filename.pdf');
}
}
