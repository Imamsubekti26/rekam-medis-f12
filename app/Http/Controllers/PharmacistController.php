<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PharmacistController extends Controller
{
    /**
     * Generate a database query based on search and sort request
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder<User>
     */
    private function generateQuery(Request $request)
    {
        $query = User::query();
        $query = $query->where("is_admin", false)->where('role', 'pharmacist');

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
                default => ["created_at", "asc"]
            };
            $query = $query->orderBy($sort[0],$sort[1]);
        } else {
            $query = $query->orderBy("created_at","asc");
        }
        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->generateQuery($request);

        try {
            $pharmacists = $query->paginate(10);
            return view("pharmacist.list", compact('pharmacists'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pharmacist.create');
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
        $validated['role'] = 'pharmacist';

        event(new Registered(($user = User::create($validated))));
        return redirect()->route('pharmacist.index')->with('success',__('pharmacist.create_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $pharmacist)
    {
        try {
            $medical_records = MedicalRecord::with('doctor')->where('doctor_id','=', $pharmacist->id)->get();
            return view('pharmacist.detail', compact('pharmacist', 'medical_records'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('pharmacist.index')->withErrors(__('pharmacist.show_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has handled by 'show' route, this method is not necesary again
     */
    public function edit(User $pharmacist)
    {
        $this->show($pharmacist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pharmacist)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'], // TODO: ensure email not listed yet
            'phone' => ['nullable', 'numeric']
        ]);
        
        try {
            $pharmacist->update($validated);
            return redirect()->route('pharmacist.index')->with('success',__('pharmacist.update_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('pharmacist.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $pharmacist)
    {
        try{
            $pharmacist->delete();
            return redirect()->route('pharmacist.index')->with('success', __('pharmacist.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('pharmacist.delete_failed'));
        }
    }
    public function printList(Request $request)
    {
        $query = $this->generateQuery($request);

        $pharmacists = $query->get(); // Ambil semua dokter tanpa pagination

        return view("pharmacist.print-list", compact("pharmacists"));
    }
}
