<?php

namespace App\Http\Controllers;

use App\Exports\TravelCompensationExport;
use App\Queries\TravelCompensationReportQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class GenerateTravelCompensationReport extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TravelCompensationReportQuery $travelCompensationReportQuery)
    {
        $request->validate([
            "month" => "required|digits:2|date_format:m",
            "year" => "required|digits:4|date_format:Y"
        ]);

        $compensations = $travelCompensationReportQuery($request->year, $request->month);
        // dd($compensations);
        $export = new TravelCompensationExport($compensations->values());

        return $export->download("Travel Compensation - {$request->year}-{$request->month}.csv", Excel::CSV);
    }
}
