<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\Status;
use App\Models\Template;
use App\Models\Departement;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Vendor;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super Admin');
    }

    //USERS
    public function users()
    {
        $users = User::all();
        $roles = Role::all();
        $departments = Departement::all();
        $units = Unit::all();
        return view('superadmin.users.index', compact('users', 'roles','departments','units'));
    }

    public function users_detail($id)
    {
        $usersdetail = UserDetail::find($id);
        $roles = Role::all();
        $units = Unit::all();
        $users = User::all();
        $departments = Departement::all();
        return view('superadmin.users.detail', ['usersdetail' => $usersdetail], compact('roles', 'units', 'departments','users'));
    }

    public function users_edit($id)
    {
        $usersdetail = UserDetail::find($id);
        $users = User::all();
        $roles = Role::all();
        $units = Unit::all();
        $departments = Departement::all();
        return view('superadmin.users.edit', compact('usersdetail','roles', 'units', 'departments','users'));
    }

    public function users_update(Request $request, $id)
    {

        $usersdetail = UserDetail::find($id);
        $usersdetail->update([
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $user = $usersdetail->user;
        $user->update ([
            'name' => $request->name,
            'nik' => $request->nik,
            'status' => $request->status
        ]);

        return redirect()->route('superadmin.users-detail', ['id' => $usersdetail->id]);
    }

    public function users_store(Request $request, FlasherInterface $flasher){
        // Membuat record pada tabel "users"
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'password' => bcrypt($request->nik),
        ]);

        // Membuat record pada tabel "user_details"
        $userDetail = UserDetail::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data pengguna!');

        return redirect()->route('superadmin.users');

    }

    //UNITS
    public function units()
    {
        $units = Unit::all();
        return view('superadmin.units.index', compact('units'));
    }

    public function units_edit($id)
    {
        $units = Unit::find($id);
        return view('superadmin.units.edit', compact('units'));
    }

    public function units_update(Request $request, $id)
    {
        $units = Unit::find($id);
        $units->update($request->all());
        return redirect()->route('superadmin.units');
    }

    public function units_store(Request $request, FlasherInterface $flasher){
      
        $units = Unit::create([
            'unit' => $request->unit,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data unit!');

        return redirect()->route('superadmin.units');
    }

    //DEPARTMENTS
    public function departments()
    {
        $departments = Departement::all();
        return view('superadmin.departments.index', compact('departments'));
    }

    public function departments_edit($id)
    {
        $departments = Departement::find($id);
        return view('superadmin.departments.edit', compact('departments'));
    }

    public function departments_update(Request $request, $id)
    {
        $departments = Departement::find($id);
        $departments->update($request->all());
        return redirect()->route('superadmin.departments');
    }

    public function departments_store(Request $request, FlasherInterface $flasher){
       
        $departments = Departement::create([
            'department' => $request->department,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data departemen!');

        return redirect()->route('superadmin.departments');
    }

    //STATUS
    public function statuses()
    {
        $statuses = Status::all();
        return view('superadmin.statuses.index', compact('statuses'));
    }

    public function statuses_edit($id)
    {
        $statuses = Status::find($id);
        return view('superadmin.statuses.edit', compact('statuses'));
    }

    public function statuses_update(Request $request, $id)
    {
        $statuses = Status::find($id);
        $statuses->update($request->all());
        return redirect()->route('superadmin.statuses');
    }

    public function statuses_store(Request $request, FlasherInterface $flasher){
       
        $statuses = Status::create([
            'status' => $request->status,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data status!');

        return redirect()->route('superadmin.statuses');
    }

    //ROLE
    public function roles()
    {
        $roles = Role::all();
        return view('superadmin.roles.index', compact('roles'));
    }

    public function roles_edit($id)
    {
        $roles = Role::find($id);
        return view('superadmin.roles.edit', compact('roles'));
    }

    public function roles_update(Request $request, $id)
    {
        $roles = Role::find($id);
        $roles->update($request->all());
        return redirect()->route('superadmin.roles');
    }

    public function roles_store(Request $request, FlasherInterface $flasher){
       
        $roles = Role::create([
            'role' => $request->role,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data role!');

        return redirect()->route('superadmin.roles');
    }

    //VENDORS
    public function vendors()
    {
        $vendors = Vendor::all();
        $usersdetail = UserDetail::all();
        return view('superadmin.vendors.index', compact('vendors', 'usersdetail'));
    }

    public function vendors_edit($id)
    {
        $vendors = Vendor::find($id);

        // dd($vendors);
        $usersdetail = UserDetail::all();
        return view('superadmin.vendors.edit', compact('vendors', 'usersdetail'));
    }

    public function vendors_update(Request $request, $id)
    {
        $vendors = Vendor::find($id);
        $vendors->update($request->all());
        return redirect()->route('superadmin.vendors');
    }

    public function vendors_store(Request $request, FlasherInterface $flasher){
       
        $vendors = Vendor::create([
            'vendor' => $request->vendor,
            'user_detail_id' => $request->user_detail_id,
            'no_eproc' => $request->no_eproc,
            'no_sap' => $request->no_sap,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data vendor!');

        return redirect()->route('superadmin.vendors');
    }

    //TEMPLATES
    public function templates()
    {
        $templates = Template::all();
        return view('superadmin.templates.index', compact('templates'));
    }

    public function templates_edit($id)
    {
        $templates = Template::find($id);
        return view('superadmin.templates.edit', compact('templates'));
    }

    public function templates_update(Request $request, $id)
    {
        $templates = Template::find($id);
        $templates->update($request->all());
        return redirect()->route('superadmin.templates');
    }

    public function templates_store(Request $request, FlasherInterface $flasher){
       
        $templates = Template::create([
            'template' => $request->template,
            'unit' => $request->unit,
        ]);

        $flasher->addSuccess('Berhasil menambahkan data template!');

        return redirect()->route('superadmin.templates');
    }
}
