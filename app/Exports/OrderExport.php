<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->query instanceof Builder) {
            return $this->query->get();
        }

        return \App\Model\TxnOrder::query()->get();
    }
}
