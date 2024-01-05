<!DOCTYPE html>
<html>
<head>
	<title>Invoice {{'INV'.str_pad($order->id, 4, '0', STR_PAD_LEFT)}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5 class="py-2">Invoice {{'INV'.str_pad($order->id, 4, '0', STR_PAD_LEFT)}}</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead class="text-center">
			<tr>
				<th>Product</th>
				<th>Variant</th>
				<th>Harga</th>
				<th>QTY</th>
				<th>Potongan Harga</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($order->detail as $detail)
			<tr>
				<td>{{$detail->variant->product->name}}</td>
				<td>{{$detail->variant->name}}</td>
				<td>{{$detail->price}}</td>
				<td>{{$detail->qty}}</td>
				<td>- {{$detail->discount}}</td>
				<td>{{$detail->total}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="5" class="text-center">Potongan Promo</td>
				<td>- {{$order->discount_promo}}</td>
			</tr>
			<tr>
				<td colspan="5" class="text-center">Total</td>
				<td>{{rupiah($order->total_price)}}</td>
			</tr>
		</tbody>
	</table>
	<small>Tanggal pemesanan: {{tgltime($order->created_at)}}</small><br>
	<small>Status: {{$order->status}}</small>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>