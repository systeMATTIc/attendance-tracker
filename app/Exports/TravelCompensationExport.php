<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TravelCompensationExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $compensations;

    public function __construct(Collection $compensations)
    {
        $this->compensations = $compensations;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Employee",
            "Transport",
            "Travelled Distance",
            "Compensation",
            "Payment Date"
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->compensations;
    }
}
