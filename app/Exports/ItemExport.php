<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::select('code', 'name', 'status', 'category_id', 'brand_id', 'created_by', 'updated_by')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'code' => $item->code,
                            'name' => $item->name,
                            'status' => $item->status==1?'Active':'Inactive',
                            'category_id' => $item->category_info?$item->category_info->name:'Deleted',
                            'brand_id' => $item->brand_info?$item->brand_info->name:'Deleted',
                            'created_by' => $item->created_info?$item->created_info->first_name.' '.$item->created_info->last_name:'Deleted',
                            'updated_by' => $item->updated_info?$item->updated_info->first_name.' '.$item->updated_info->last_name:'Deleted',
                        ];
                    });
    }

    /**
     * Define the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Status',
            'Category ID',
            'Brand ID',
            'Created By',
            'Updated By'
        ];
    }
}
