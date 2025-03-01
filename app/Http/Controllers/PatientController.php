<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has("search") && $request->search != null) {
            $query = $query->where("name","like","%". $request->search ."%")
                ->orWhere("address","like","%". $request->search ."%")
                ->orWhere("member_id","like","%". $request->search ."%");
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "name_asc" => ["name", "asc"],
                "name_desc" => ["name", "desc"],
                "member_id_asc" => ["member_id", "asc"],
                "member_id_desc" => ["member_id", "desc"],
                "address_asc" => ["address", "asc"],
                "address_desc" => ["address", "desc"],
            };
            $query = $query->orderBy($sort[0],$sort[1]);
        } else {
            $query = $query->orderBy("created_at","asc");
        }

        try {
            $patients = $query->paginate(10);
            return view("patient.list", ["patients"=> $patients]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("patient.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'numeric'],
            'is_male' => ['nullable', 'boolean'],
            'date_of_birth'=> ['nullable', 'date'],
        ]);

        try {
            Patient::create($validated);
            return redirect()->route('patient.index')->with('success',__('patient.create_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors('patient.create_failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        try {
            $patient_data = Patient::find($patient->id);
            return view('patient.detail', ['patient' => $patient_data]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('patient.index')->withErrors(__('patient.show_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has handled by 'show' route, this method is not necesary again
     */
    public function edit(Patient $patient)
    {
        $this->show($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'member_id' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'numeric'],
            'is_male' => ['nullable', 'boolean'],
            'date_of_birth'=> ['nullable', 'date'],
        ]);

        try {
            Patient::find($patient->id)->update($validated);
            return redirect()->route('patient.index')->with('success',__('patient.update_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors('patient.update_failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try{
            Patient::find($patient->id)->delete();
            return redirect()->route('patient.index')->with('success', __('patient.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors('patient.delete_failed');
        }
    }
}
