<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

class ViewAllAttendances extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize("viewAny", Attendance::class);

        return view('user_attendances.index', [
            "attendances" => Attendance::orderBy('time_in', "desc")->paginate(10)
        ]);
    }
}
