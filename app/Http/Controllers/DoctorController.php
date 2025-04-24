<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        $query = $query->where("is_admin", false);

        if ($request->has("search") && $request->search != null) {
            $query = $query->where(function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%")
                    ->orWhere("email", "like", "%" . $request->search . "%")
                    ->orWhere("id", "like", "%" . $request->search . "%");
            });
        }

        if ($request->has("sort_by") && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                "name_asc" => ["name", "asc"],
                "name_desc" => ["name", "desc"],
                "email_asc" => ["email", "asc"],
                "email_desc" => ["email", "desc"],
            };
            $query = $query->orderBy($sort[0],$sort[1]);
        } else {
            $query = $query->orderBy("created_at","asc");
        }

        try {
            $doctors = $query->paginate(10);
            return view("doctor.list", compact('doctors'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));
        return redirect()->route('doctor.index')->with('success',__('doctor.create_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $doctor)
    {
        try {
            $medical_records = MedicalRecord::with('doctor')->where('doctor_id','=', $doctor->id)->get();
            return view('doctor.detail', compact('doctor', 'medical_records'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('doctor.index')->withErrors(__('doctor.show_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has handled by 'show' route, this method is not necesary again
     */
    public function edit(User $doctor)
    {
        $this->show($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $doctor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'], // TODO: ensure email not listed yet
            'phone' => ['nullable', 'numeric']
        ]);
        
        try {
            $doctor->update($validated);
            return redirect()->route('doctor.index')->with('success',__('doctor.update_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('doctor.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        try{
            $doctor->delete();
            return redirect()->route('doctor.index')->with('success', __('doctor.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('doctor.delete_failed'));
        }
    }
    public function printList(Request $request)
{
    $query = User::query()->where("is_admin", false); // Ambil semua dokter (non-admin)

    // Pencarian berdasarkan nama, alamat, atau member_id
    if ($request->has("search") && $request->search != null) {
        $query->where(function ($q) use ($request) {
            $q->where("name", "like", "%" . $request->search . "%")
                ->orWhere("address", "like", "%" . $request->search . "%")
                ->orWhere("member_id", "like", "%" . $request->search . "%");
        });
    }

    // Sorting berdasarkan parameter yang diterima
    if ($request->has("sort_by") && $request->sort_by != null) {
        $sort = match ($request->sort_by) {
            "name_asc" => ["name", "asc"],
            "name_desc" => ["name", "desc"],
            "member_id_asc" => ["member_id", "asc"],
            "member_id_desc" => ["member_id", "desc"],
            "address_asc" => ["address", "asc"],
            "address_desc" => ["address", "desc"],
            default => ["created_at", "asc"]
        };
        $query = $query->orderBy($sort[0], $sort[1]);
    } else {
        $query = $query->orderBy("created_at", "asc");
    }

    $doctors = $query->get(); // Ambil semua dokter tanpa pagination

    return view("doctor.print-list", compact("doctors"));
}

}
