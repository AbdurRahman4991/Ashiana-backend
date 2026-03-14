<h2>Invoice #{{ $order->id }}</h2>

<p>Status: {{ $order->status }}</p>

<table border="1" width="100%" cellpadding="10">

<thead>

<tr>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
</tr>

</thead>

<tbody>

@foreach($order->orderItems as $item)

<tr>

<td>{{ $item->product->name }}</td>

<td>{{ $item->selling_price }}</td>

<td>{{ $item->qty }}</td>

<td>{{ $item->discounted_price }}</td>

</tr>

@endforeach

</tbody>

</table>

<h3>Total: {{ $order->total }}</h3>