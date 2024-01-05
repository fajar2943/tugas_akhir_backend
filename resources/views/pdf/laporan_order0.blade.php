<!DOCTYPE html>
<html>
<head>
	<title>Laporan Penjualan MyPackaging</title>
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
		<h5 class="py-2">Laporan Penjualan MyPackaging</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead class="text-center">
			<tr>
				{{-- <th rowspan="2" style="width: 3%">No</th> --}}
				<th>Produk</th>
				<th>Total Penjualan</th>
				<th>Sub total</th>
				<th>Diskon</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			{{-- @php $i=1 @endphp --}}
			@foreach($order as $order)
			<tr>
				{{-- <td>{{ $i++ }}</td> --}}
				<td>{{$order->product_name}} ({{$order->variant_name}})</td>
				<td>{{$order->total_orders}}</td>
				<td>{{$order->subtotals}}</td>
				<td>{{$order->total_discount}}</td>
				<td>{{$order->totals}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		print();
	</script>
</body>
</html>