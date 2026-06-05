<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Landmark</th>
            <th>City</th>
            <th>Territory</th>
            <th>Pincode</th>
            <th>Product Information</th>
            <th>Total Before Tax</th>
            <th>Tax</th>
            <th>Total Amount</th>
            <th>Merchant ID</th>
            <th>Transaction ID</th>
            <th>Transaction Amount</th>
            <th>Payment Mode</th>
            <th>Currency</th>
            <th>Transaction Date</th>
            <th>Transaction Status</th>
            <th>Response Code</th>
            <th>Response Message</th>
            <th>Gateway Name</th>
            <th>Bank Name</th>
            <th>Checksum Hash</th>
            <th>Bank Transaction ID</th>
            <th>Order Status</th>
            <th>Order On</th>
        </tr>
    </thead>
    <tbody>
        <tr></tr>
        @foreach($orders as $key => $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->user?->email ?? 'N/A' }}</td>
            <td>{{ $order->user?->mobile ?? 'N/A' }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->landmark }}</td>
            <td>{{ $order->city }}</td>
            <td>{{ $order->territory }}</td>
            <td>{{ $order->pincode }}</td>
            <td>
                @foreach($order->details as $detail)
                Name : {{ $detail->title }} <br />
                MRP : {{ $detail->mrp }} <br />
                Volume : {{ $detail->volume }} <br />
                Quantity : {{ $detail->quantity }} <br />
                @endforeach
            </td>
            <td>{{ $order->tbt }}</td>
            <td>{{ $order->tax }}</td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->transaction['MID'] }}</td>
            <td>{{ $order->transaction['TXNID'] }}</td>
            <td>{{ $order->transaction['TXNAMOUNT'] }}</td>
            <td>{{ $order->transaction['PAYMENTMODE'] }}</td>
            <td>{{ $order->transaction['CURRENCY'] }}</td>
            <td>{{ $order->transaction['TXNDATE'] }}</td>
            <td>{{ $order->transaction['STATUS'] }}</td>
            <td>{{ $order->transaction['RESPCODE'] }}</td>
            <td>{{ $order->transaction['RESPMSG'] }}</td>
            <td>{{ $order->transaction['GATEWAYNAME'] }}</td>
            <td>{{ $order->transaction['BANKNAME'] }}</td>
            <td>{{ $order->transaction['CHECKSUMHASH'] }}</td>
            <td>{{ $order->transaction['BANKTXNID'] }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
