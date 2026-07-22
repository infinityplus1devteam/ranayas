@extends('layouts.admin-master')
@section('title', 'Manage Orders')
@section('content')

    <section class="section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-dark text-white-all">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.all') }}"><i class="fas fa-shopping-cart"></i>
                        All Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Orders</li>

            </ol>
        </nav>

        <div class="card">
            <div class="card-header bg-dark text-white-all">
                <h4>Contact Information</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Order ID</th>
                            <td>{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td>{{ $order->user_name }}</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>{{ $order->user?->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>{{ $order->user?->mobile ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $order->address }}, {{ $order->landmark ? $order->landmark : '' }}, {{ $order->city }},
                                {{ $order->territory }}, {{ $order->pincode }}
                            </td>
                        </tr>
                        @if($order->type_of_address)
                            <tr>
                                <th>Type of Address</th>
                                <td>{{ $order->type_of_address ? 'Home' : ' Office/Commercial' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Order Date</th>
                            <td>{{ date('d-M-Y h:i A', strtotime($order->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>
                                {{ $order->payment_status }}
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Mode</th>
                            <td class="text-capitalize">
                                {{ $order->payment_mode }}
                            </td>
                        </tr>

                        <tr>
                            <th>Order Status</th>
                            <td>
                                <div class="mt-1">
                                    <form action="{{ url('adranayas753/manage-orders/show/'.$order->id) }}" method="post" class="form-inline">
                                        @csrf
                                        <div class="form-group mr-2">
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">--Select Status--</option>
                                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @if($order->promocode)
                            <tr>
                                <th>Promocode</th>
                                <td>{{ $order->promocode }}</td>
                            </tr>
                        @endif

                        @if($order->status === 'Delivered' && $order->delivery_date)
                            <tr>
                                <th>Delivered At</th>
                                <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-M-Y') }}</td>
                            </tr>
                        @endif

                        @if(
                                            !empty($order->return_status) && $order->return_status != 'Approved' &&
                                            $order->return_status != 'Reject'
                                        )
                                        <tr>
                                            <th>Return Status</th>
                                            <td>
                                                {{ $order->return_status }}
                                                <div class="mt-10">
                                                    <form action="{{ route('admin.orders.return-status', $order->id) }}" method="post"
                                                        class="form-inline">
                                                        @csrf
                                                        <div class="form-group mr-2">
                                                            <select name="return_status" id="return_status" class="form-control">
                                                                <option value="">--Select Status--</option>
                                                                <option value="Applied" {{ $order->return_status == 'Applied' ? 'selected' : ''
                                                                    }}>
                                                                    Applied
                                                                </option>
                                                                <option value="In Progress" {{ $order->return_status == 'In Progress' ?
                            'selected' : '' }}>
                                                                    In Progress
                                                                </option>
                                                                <option value="Approved" {{ $order->return_status == 'Approved' ? 'selected' :
                            '' }}>
                                                                    Approved
                                                                </option>
                                                                <option value="Rejected" {{ $order->return_status == 'Rejected' ? 'selected' :
                            '' }}>
                                                                    Rejected
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                        @endif

                        @if(!empty($order->return_status))
                            <tr>
                                <th>Return Status</th>
                                <td>
                                    {{ $order->return_status }}
                                </td>
                            </tr>
                            <tr>
                                <th>Reason</th>
                                <td>
                                    {{ $order->cancel_reason }}
                                </td>
                            </tr>
                        @endif

                        @if($order->other_reason)
                            <tr>
                                <th>other Reason</th>
                                <td>
                                    {{ $order->other_reason }}
                                </td>
                            </tr>
                        @endif

                        @if($order->image_url)
                            <tr>
                                <th>Image Uploaded</th>
                                <td>
                                    <a href="{!! asset('/storage/images/order-returns/' . $order->image_url) !!}"
                                        target="_blank">
                                        <img src="{!! asset('/storage/images/order-returns/' . $order->image_url) !!}"
                                            alt="Return Product Image" width="50">
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white-all">
                <h4>Order Information</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>MRP</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->details as $detail)

                            @php
                                $offers = json_decode($detail->offers);
                                $exp_offers = explode(",", $offers);
                                $image = \App\Model\TxnImage::image($detail->product_id, $detail->color_id);
                            @endphp
                            <tr>
                                <td>
                                    <a href="{!! asset('/storage/images/multi-products/' . $image->image_url) !!}"
                                        target="_blank"><img
                                            data-src="{!! asset('/storage/images/multi-products/' . $image->image_url) !!}"
                                            alt="{{ $detail->product->title }}" width="50" class="img img-responsive lazy"></a>
                                </td>
                                <td>
                                    {{ $detail->product->title }} <br>

                                    {{ ($detail->size && strtolower($detail->size->title) !== 'null') ? 'Size: ' . $detail->size->title : '' }} <br>
                                    {{ $detail->color ? 'Color: ' . $detail->color->title : '' }}
                                    @if($offers)
                                        @if(!empty($exp_offers))
                                            <br>
                                            <br>
                                            @foreach($exp_offers as $ofr)
                                                @php
                                                    $offer = \App\Model\MapMstOfferProduct::where('id', $ofr)->with(
                                                        'product',
                                                        'color',
                                                        'size'
                                                    )->first();
                                                @endphp

                                                + {{ $offer->product->title }} [{{ $offer->size->title }} ML] <br />
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $detail->mrp }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->mrp * $detail->quantity }}</td>
                            </tr>

                        @endforeach

                        <tr>
                            <th colspan="5" class="bg-silver text-right text-uppercase">
                                @php
                                    $itemSubtotal = 0;
                                    foreach($order->details as $detail) {
                                        $itemSubtotal += $detail->mrp * $detail->quantity;
                                    }
                                    $shipping = $itemSubtotal > 0 && $itemSubtotal < 199 ? 80 : 0;
                                @endphp
                                <p>Item Subtotal : &#8377; {{ $itemSubtotal }}</p>
                                {{-- GST breakdown hidden (no GST number available)
                                @if($order->tax > 0)
                                    <p style="font-weight: normal; color: #555;">(Includes CGST : &#8377; {{ round($order->tax / 2, 2) }})</p>
                                    <p style="font-weight: normal; color: #555;">(Includes SGST : &#8377; {{ round($order->tax / 2, 2) }})</p>
                                @endif
                                --}}
                                <p>- Discount : &#8377; {{ $order->discount ? $order->discount : 0 }}</p>
                                @if($shipping > 0)
                                <p>+ Shipping : &#8377; {{ $shipping }}</p>
                                @endif
                                <p>Grand Total : &#8377; {{ $order->total }}</p>
                            </th>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white-all">
                <h4>Order Tracking</h4>
            </div>
            <div class="card-body table-responsive">
                @if($track_response)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        <span class="pull-left text-dark">Order Pickedup Origin :
                                            {{ $track_response['Origin'] }}</span> <Span class="pull-right text-dark">Order
                                            Pickedup
                                            Date :
                                            {{ date('d-M-Y h:i A', strtotime($track_response['PickUpDate'])) }}</Span>
                                    </th>
                                </tr>

                                <tr class="thead-dark">
                                    <th>Instructions</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            @if($track_response['Scans'])
                                <tbody>
                                    @foreach($track_response['Scans'] as $scan)
                                        <tr>
                                            <td>
                                                {{ $scan['ScanDetail']['Instructions'] }}
                                            </td>
                                            <td>
                                                {{ $scan['ScanDetail']['ScannedLocation'] }}
                                            </td>
                                            <td>
                                                {{ date('d-M-Y h:i A', strtotime($scan['ScanDetail']['StatusDateTime'])) }}
                                            </td>
                                            <td>
                                                {{ $scan['ScanDetail']['Scan'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                @endif
        </div>

        @if($order->transaction)
            <div class="card">
                <div class="card-header bg-dark text-white-all">
                    <h4>Transaction Details</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover datatable" style="width:100%;">
                        <tbody>
                            <tr>
                                <td>Merchant ID</td>
                                <td>{{$order->transaction->MID}}</td>
                            </tr>
                            <tr>
                                <td>Transaction ID</td>
                                <td>{{$order->transaction->TXNID}}</td>
                            </tr>
                            <tr>
                                <td>Transaction Amount</td>
                                <td>{{$order->transaction->TXNAMOUNT}}</td>
                            </tr>
                            <tr>
                                <td>Payment Mode</td>
                                <td>{{$order->transaction->PAYMENTMODE}}</td>
                            </tr>
                            <tr>
                                <td>Currency</td>
                                <td>{{$order->transaction->CURRENCY}}</td>
                            </tr>
                            <tr>
                                <td>Transaction Date</td>
                                <td>{{date('d-M-Y h:i A', strtotime($order->transaction->TXNDATE))}}</td>
                            </tr>
                            <tr>
                                <td>Transaction Status</td>
                                <td>{{$order->transaction->STATUS}}</td>
                            </tr>
                            <tr>
                                <td>Response Code</td>
                                <td>{{$order->transaction->RESPCODE}}</td>
                            </tr>
                            <tr>
                                <td>Response Message</td>
                                <td>{{$order->transaction->RESPMSG}}</td>
                            </tr>
                            <tr>
                                <td>Gateway Name</td>
                                <td>{{$order->transaction->GATEWAYNAME}}</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td>{{$order->transaction->BANKNAME}}</td>
                            </tr>
                            <tr>
                                <td>Checksum Hash</td>
                                <td>{{$order->transaction->CHECKSUMHASH}}</td>
                            </tr>
                            <tr>
                                <td>Bank Transaction ID</td>
                                <td>{{$order->transaction->BANKTXNID}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </section>
@endsection
