<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class ClockOutFromWorkPlace extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Attendance $attendance)
    {
        abort_unless($attendance->user()->is($request->user()), 404);

        try {
            $attendance->close();
            $request->session()->flash("status", "Check out successfull !!!");
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }

        return redirect()->route("my-attendances.index");
    }
}
