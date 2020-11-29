<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('user_attendances.index', [
            "attendances" => $request->user()->attendances()
                ->orderBy('time_in', "desc")
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user_attendaces.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->user()->logOwnAttedance();
            $request->session()->flash("status", "Attendance logged successfully !!!");
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }

        return redirect()->action([self::class, 'index']);
    }
}
