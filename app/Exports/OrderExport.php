<?php

namespace App\Exports;

use App\Model\TxnOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TxnOrder::all();
    }
}
