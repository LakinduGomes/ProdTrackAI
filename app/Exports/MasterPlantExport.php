<?php
namespace App\Exports;

use App\Models\MasterPlant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterPlantExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return the collection of data to be exported
     */
    public function collection()
    {
        return MasterPlant::select('code', 'status')->get(); // Only 'Code' and 'Status'
    }

    /**
     * Return the headings of the CSV file
     */
    public function headings(): array
    {
        return ['Code', 'Status']; // Only 'Code' and 'Status' as the headers
    }

    /**
     * Map each row in the collection
     */
    public function map($row): array
    {
        return [
            $row->code, // Column 'Code'
            $row->status ? 'Active' : 'Inactive', // Column 'Status'
        ];
    }
}


?>