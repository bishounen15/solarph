<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TaxStatus as TaxStatus;

use DataTables;

class TaxStatusController extends Controller
{
    //
    public function __construct( TaxStatus $tax_status )
    {
        $this->tax_status = $tax_status->all();
    }

    public function show() {
        $data = [];
        $data['tax_statuses'] = TaxStatus::orderBy('code')->get();

        return view('hris.setup.taxstatus.show',$data);
    }

    public function newRecord(Request $request, TaxStatus $tax_status)
    {
        $tax_instance = new TaxStatus();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.tax_statuses',
                'description' => 'required|max:25|unique:hris.tax_statuses',
            ]);

            $tax_status->create($data);
            return redirect('hris/setup/taxstatus');
        }

        $data['modify'] = 0;
        return view('hris.setup.taxstatus.form', $data);
    }

    public function modifyRecord(Request $request, TaxStatus $tax_status, $tax_id)
    {
        $tax_instance = new TaxStatus();
        $data = [];

        $data['description'] = $request->input('description');
        $data['active'] = $request->input('active');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $tax_data = $this->tax_status->find($tax_id);
            
            if ($tax_data->description != $data['description']) {
                $validation = 'required|max:25|unique:hris.tax_statuses';
            } else {
                $validation = 'required|max:25';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $tax_data->description = $data['description'];
            $tax_data->uid_modify = $data['uid_modify'];

            $tax_data->save();
            return redirect('hris/setup/taxstatus');
        }

        $data['modify'] = 0;
        return view('hris.setup.taxstatus.form', $data);
    }

    public function removeRecord($tax_id) {
        $tax_data = $this->tax_status->find($tax_id);
        
        if ($tax_data->isUsed()) {
            return redirect('hris/setup/taxstatus')->with('fail',$tax_data->description.' could not be deleted as it was already associated with an existing employee.');
        } else {
            $tax_data->delete();
            return redirect('hris/setup/taxstatus');
        }
    }

    public function showRecord($tax_id){
        $data = [];

        $data['tax_id'] = $tax_id;
        $data['modify'] = 1;
                
        $tax_data = $this->tax_status->find($tax_id);

        $data['code'] = $tax_data->code;
        $data['description'] = $tax_data->description;
        
        return view('hris.setup.taxstatus.form', $data);
    }

    public function listTaxStatuses() {
        $tax_statuses = TaxStatus::selectRaw('id, code, description');
        return Datatables::of($tax_statuses)->make(true);
    }
}
