<table>
    <thead>
        <tr>
            <th>Sl</th>
            <th>Order</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Price</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderdetails as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->first_name }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->payment_status == 1 ? 'Pending' : 'Paid' }}</td>
                <td>{{ $order->grand_total }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">Total Purchase Cost</td>
            <td colspan="2">{{ $totalPurchaseCost->total_purchase_cost }}</td>
        </tr>
    </tbody>
</table>
