<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DoctorSchedule::query();

        if ($request->user()->role == 'doctor') {
            $query = $query->where('doctor_id', $request->user()->id);
        }

        if ($request->has('search') && $request->search != null) {
            $query = $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('sort_by') && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                'date_asc' => ['available_date', 'asc'],
                'date_desc' => ['available_date', 'desc'],
                'start_time_asc' => ['start_time', 'asc'],
                'start_time_desc' => ['start_time', 'desc'],
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy('available_date', 'desc');
        }

        try {
            $schedules = $query->paginate(10);
            return view('schedule.list', compact('schedules'));
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
            $doctors = User::where('is_admin', false)->where('role', 'doctor')->get(); // ambil hanya dokter
            
            return view('schedule.create', compact('doctors'));
        } catch (\Exception $e) {
            dd($e); // untuk debug kalau error
            return redirect()->route('schedule.index')->withErrors(__('schedule.show_failed'));
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'available_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'handle_count' => ['required', 'integer'],
            'schedule_type' => ['required', 'in:Sequential,Random'], // harus pilih salah satu enum
        ]);

        try {
            DoctorSchedule::create($validated);
            return redirect()->route('schedule.index')->with('success', __('schedule.create_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('schedule.create_failed'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(DoctorSchedule $schedule)
    {
        return view('schedule.detail', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     * @deprecated the edit form has been handled by 'show' route, this method is not necessary again
     */
    public function edit(DoctorSchedule $schedule)
    {
        $this->show($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DoctorSchedule $schedule)
    {
        $validated = $request->validate([
            'available_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'handle_count' => ['required', 'integer'],
            'schedule_type' => ['nullable', 'string'], // bisa kosong atau salah satu dari Sequential/Random
        ]);

        try {
            $schedule->update($validated);
            return redirect()->route('schedule.index')->with('success', __('schedule.update_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('schedule.update_failed'));
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DoctorSchedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('schedule.index')->with('success', __('schedule.delete_success'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(__('schedule.delete_failed'));
        }
    }

    /**
     * Print a list of the schedules.
     */
    public function printList(Request $request)
    {
        $query = DoctorSchedule::query();

        if ($request->has('search') && $request->search != null) {
            $query = $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('sort_by') && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                'date_asc' => ['available_date', 'asc'],
                'date_desc' => ['available_date', 'desc'],
                'start_time_asc' => ['start_time', 'asc'],
                'start_time_desc' => ['start_time', 'desc'],
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy('available_date', 'desc');
        }

        $schedules = $query->get(); // ambil semua tanpa pagination

        return view('schedule.print-list', compact('schedules'));
    }
}
