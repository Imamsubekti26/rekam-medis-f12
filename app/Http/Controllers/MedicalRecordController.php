<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MedicalRecord::query();
        $query->select(['medical_records.*'])->join("patients", "patients.id", "=", "medical_records.patient_id");

        if ($request->has("search") && $request->search != null) {
            $query->where("record_number","like","%". $request->search ."%")
                ->orWhere("patients.name","like","%". $request->search ."%");
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "record_number_asc" => ["record_number", "asc"],
                "record_number_desc" => ["record_number", "desc"],
                "date_asc" => ["date", "asc"],
                "date_desc" => ["date", "desc"],
                "patient_asc" => ["patients.name", "asc"],
                "patient_desc" => ["patients.name", "desc"],
            };
            $query->orderBy($sort[0],$sort[1]);
        } else {
            $query->orderBy("created_at","asc");
        }

        try {
            $record = $query->with('doctor')->with('patient')->paginate(10);
            return view("medical_record.list", ['records' => $record]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $doctors = $request->user()->is_admin 
                ? User::where('is_admin', false)->get() 
                : [$request->user()];
            
            $patients = $request->has('patient_id') && $request->patient_id != null
                ? Patient::find($request->patient_id)
                : Patient::all();
    
            return view('medical_record.create', compact('doctors', 'patients'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('record.index')->withErrors(__('medical_record.show_failed'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @deprecated the behaviour of 'store' action has been handle by livewire 'medical-record/index'.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $record)
    {
        try {
            $record_data = MedicalRecord::find($record->id);
            return view('medical_record.detail', ['record' => $record_data]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('record.index')->withErrors(__('medical_record.show_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has handled by 'show' route, this method is not necesary again
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $this->show($medicalRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $record)
    {
        try{
            MedicalRecord::find($record->id)->delete();
            return redirect()->route('record.index')->with('success', __('medical_record.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('medical_record.delete_failed'));
        }
    }
}
