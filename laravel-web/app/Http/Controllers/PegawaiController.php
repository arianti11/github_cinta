<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data dasar
        $name = "Cinta Dwi Arianti";
        $tanggal_lahir = Carbon::createFromDate(2006, 06, 11);
        $my_age = intval($tanggal_lahir->diffInYears(Carbon::now()));
        $hobbies = ["Main game", "Dengarin musik", "Nonton film", "Olahraga"];
        $tgl_harus_wisuda = Carbon::createFromDate(2028, 8, 16);
        $time_to_study_left = Carbon::now()->diffInDays($tgl_harus_wisuda, false);
        $current_semester = 3;
        $info = $current_semester < 3 ? "Masih Awal, Kejar TAK!" : "Jangan main-main, kurangi main game!";
        $future_goal = "Ingin Bermanfaat bagi banyak orang";

        // Sertakan data session login juga bila ada
        $username = session('username', null);
        $last_login = session('last_login', null);

        return view('home', compact(
            'name',
            'my_age',
            'hobbies',
            'tgl_harus_wisuda',
            'time_to_study_left',
            'current_semester',
            'info',
            'future_goal',
            'username',
            'last_login'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
