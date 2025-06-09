<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
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
        $query = Patient::withCount('medical_records'); // eager load count rekam medis

        if ($request->has("search") && $request->search != null) {
            $query = $query->where("name", "like", "%" . $request->search . "%")
                ->orWhere("address", "like", "%" . $request->search . "%")
                ->orWhere("nik", "like", "%" . $request->search . "%");
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "name_asc" => ["name", "asc"],
                "name_desc" => ["name", "desc"],
                "nik_asc" => ["nik", "asc"],
                "nik_desc" => ["nik", "desc"],
                "address_asc" => ["address", "asc"],
                "address_desc" => ["address", "desc"],
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy("created_at", "asc");
        }

        try {
            $patients = $query->paginate(10);
            return view("patient.list", compact('patients'));
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
            'nik' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'numeric'],
            'is_male' => ['nullable', 'boolean'],
            'date_of_birth' => ['nullable', 'date'],
            'food_allergies' => ['nullable', 'string'],
            'drug_allergies' => ['nullable', 'string'],
        ]);

        try {
            Patient::create($validated);
            return redirect()->route('patient.index')->with('success', __('patient.create_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('patient.create_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        try {
            $medical_records = MedicalRecord::with('patient')->where('patient_id', $patient->id)->get();
            return view('patient.detail', compact('patient', 'medical_records'));
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
            'nik' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'numeric'],
            'is_male' => ['nullable', 'boolean'],
            'date_of_birth' => ['nullable', 'date'],
            'food_allergies' => ['nullable', 'string'],
            'drug_allergies' => ['nullable', 'string'],
        ]);

        try {
            $patient->update($validated);
            return redirect()->route('patient.show', $patient->id)->with('success', __('patient.update_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('patient.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect()->route('patient.index')->with('success', __('patient.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('patient.delete_failed'));
        }
    }

    public function printList(Request $request)
    {
        $query = Patient::query();

        if ($request->has("search") && $request->search != null) {
            $query->where(function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%")
                    ->orWhere("address", "like", "%" . $request->search . "%")
                    ->orWhere("nik", "like", "%" . $request->search . "%");
            });
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "name_asc" => ["name", "asc"],
                "name_desc" => ["name", "desc"],
                "nik_asc" => ["nik", "asc"],
                "nik_desc" => ["nik", "desc"],
                "address_asc" => ["address", "asc"],
                "address_desc" => ["address", "desc"],
                default => ["created_at", "asc"]
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy("created_at", "asc");
        }

        $patients = $query->get(); // ambil semua tanpa pagination

        return view("patient.print-list", compact("patients"));
    }
    public function printByPatient(Patient $patient)
    {
        $medical_records = $patient->medical_records()->with('doctor')->get();

        return view('patient.print-rm', compact('patient', 'medical_records'));
    }
}
