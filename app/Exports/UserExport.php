<?php

namespace App\Exports;

use App\Model\TxnUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TxnUser::select(
            'id',
            'name',
            'email',
            'mobile',
            'company_name',
            'address',
            'city',
            'territory',
            'pincode',
            'country',
            'gst',
            'status',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Mobile',
            'Company Name',
            'Address',
            'City',
            'State/Territory',
            'Pincode',
            'Country',
            'GST',
            'Status (1=Active, 0=Blocked)',
            'Registered At',
        ];
    }
}
