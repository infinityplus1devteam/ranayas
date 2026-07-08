<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        * {
            font-family: 'Segoe UI';
            color: #504E4E;
            font-size: 11px;
        }

        th {
            font-weight: 600;
            text-align: left;
        }

        .bg-silver {
            background-color: #eee;
        }

        h4 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
            margin: 5px;
        }

        .container {
            padding-left: 2px;
            margin: 0 auto;
        }

        .row:after {
            clear: both;
        }

        .clear_both {
            clear: both;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .row:after,
        .row:before {
            display: table;
            content: " ";
        }



        .bg-silver {
            background-color: #eee !important;
            padding: 3px;
        }

        .col-sm-6 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .text-capitalize {
            text-transform: capitalize;
        }


        .col-sm-6 {
            float: left;
        }

        .col-sm-6 {
            width: 100%;
        }

        .col-sm-12 {
            width: 100%;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d !important;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .table {
            border-collapse: collapse !important;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        .table-responsive>.table {
            margin-bottom: 0;
        }

        .table tr td,
        .table tr th {
            padding: 5px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd !important
        }

        .text-right {
            text-align: right;
        }

        .table-responsive {
            width: 100%;
            margin-bottom: 15px;
            overflow-y: hidden;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            border: 1px solid #ddd;
            min-height: .01%;
            overflow-x: auto
        }

        .invoice_span {
            float: right;
        }

        @media (min-width:768px) {
            .container {
                width: 650px
            }
        }

        @media (min-width:992px) {
            .container {
                width: 870px
            }
        }

        @media (min-width:1200px) {
            .container {
                width: 970px;
            }
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        .company_title {
            font: 600 14px normal bold;
            text-transform: uppercase;
            margin-bottom: 5px !important;
        }

        .company_address {
            font-size: 9px !important;
        }

        .pb-20 {
            padding-bottom: 20px !important;
            /* height: 150px !important; */
        }

        .pull-right {
            text-align: right !important;
        }

        .total {
            text-align: right !important;
            padding-right: 50px !important;
        }

        .total span {
            font-size: 14px;
            font-weight: bold;
        }

        table tr th {
            font-size: 12px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-responsive">
                    <tr class="pb-20">
                        <td colspan="2">
                            <p class="text-center">
                            <p class="company_title text-center"> Ranayas </p>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <span class="company_address ">
                                OFFICE : Kandivali West, Mumbai, Maharashtra, India
                            </span>
                        </td>
                    </tr>
                    @if ($dates['from_date'])
                        <tr>
                            <td colspan="2" class="text-center">
                                <h1>From Date : {{ $dates['from_date'] }} @if ($dates['to_date'])
                                        To {{ $dates['to_date'] }}
                                    @endif
                                </h1>
                            </td>
                        </tr>
                    @endif
                    @if ($filter)
                        <tr>
                            <td colspan="2" class="text-center">
                                <h1>Filter : {{ $filter }}</h1>
                            </td>
                        </tr>
                    @endif
                </table>

                <table border="1" class="table table-bordered table-responsive">
                    <tr>
                        <th colspan="12" class="text-center text-uppercase bg-silver">
                            Order Information
                        </th>
                    </tr>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer_Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Pincode</th>
                        <th>Amount(In Rs)</th>
                        <th>Status</th>
                        <th>Ordered On</th>
                    </tr>

                    @php $total = 0 @endphp
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->user?->email ?? 'N/A' }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->pincode }}</td>
                            <td>Rs.{{ $order->total }}</td>
                            <td class="text-capitalize">{{ $order->status }}</td>
                            <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                        </tr>
                        @php $total+=$order->total @endphp
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h3>No Order(s) Found </h3>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="8" class="total"> <span>Grand Total : {{ $total }}</span> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
