<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->has("search") && $request->search != null) {
            $query = $query->where("name","like","%". $request->search ."%")
                ->orWhere("barcode","like","%". $request->search ."%");
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "name_asc" => ["name", "asc"],
                "name_desc" => ["name", "desc"],
                "barcode_asc" => ["barcode", "asc"],
                "barcode_desc" => ["barcode", "desc"],
            };
            $query = $query->orderBy($sort[0],$sort[1]);
        } else {
            $query = $query->orderBy("created_at","asc");
        }

        try {
            $medicines = $query->paginate(10);
            return view("medicine.list", compact('medicines'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode'=> ['required', 'string'],
            'name'=> ['required', 'string'],
            'description'=> ['nullable', 'string'],
            'stock' => ['nullable', 'numeric'],
            'price'=> ['required','numeric'],
        ]);

        try {
            Medicine::create($validated);
            return redirect()->route('medicine.index')->with('success',__('medicine.create_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('medicine.create_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return view('medicine.detail', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has handled by 'show' route, this method is not necesary again
     */
    public function edit(Medicine $medicine)
    {
        $this->show($medicine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'barcode'=> ['required', 'string'],
            'name'=> ['required', 'string'],
            'description'=> ['nullable', 'string'],
            'stock' => ['nullable', 'numeric'],
            'price'=> ['required','numeric'],
        ]);

        try {
            $medicine->update($validated);
            return redirect()->route('medicine.index')->with('success',__('medicine.create_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('medicine.create_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        try{
            $medicine->delete();
            return redirect()->route('medicine.index')->with('success', __('medicine.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('medicine.delete_failed'));
        }
    }
}
