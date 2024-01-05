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
				<th rowspan="2" style="width: 30px">Invoice</th>
				<th rowspan="2" style="width: 30px">Tanggal Pembelian</th>
				<th rowspan="2" style="width: 30px">Nama Pembeli</th>
				<th rowspan="2" style="width: 30px">Admin</th>
				<th colspan="6" class="text-center">Pesanan</th>
				<th rowspan="2" style="width: 65px">Sub Total</th>
				<th rowspan="2" style="width: 65px">Potongan Promo</th>
				<th rowspan="2" style="width: 65px">Total</th>
			</tr>
			<tr>
				<th style="width: 65px">Produk</th>
				<th style="width: 30px">Qty</th>
				<th style="width: 65px">Harga / pcs</th>
				<th style="width: 65px">Sub Total / Produk</th>
				<th style="width: 65px">Diskon</th>
				<th style="width: 65px">Total / Produk</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($order as $order)
			<tr>
				{{-- <td>{{ $i++ }}</td> --}}
				<td>{{'INV'.str_pad($order->id, 4, '0', STR_PAD_LEFT)}}</td>
				<td>{{ date('j-m-Y', strtotime($order->created_at)) }}</td>
				<td>{{$order->users->name}}</td>
				<td>{{$order->admin->name}}</td>
				<td colspan="6" class="p-0">
					@foreach ($order->detail as $detail)
					<table class="table-borderless" >
							<tr class="p-0 m-0">
								<td class="py-1" style="width: 65px">{{ $detail->variant->name }}</td>
								<td class="py-1" style="width: 30px">{{ $detail->qty }}</td>
								<td class="py-1" style="width: 65px">Rp. {{ number_format(($detail->total + $detail->discount)/$detail->qty,0,',','.') }}</td>
								<td class="py-1" style="width: 65px">Rp. {{ number_format($detail->subtotal,0,',','.') }}</td>
								<td class="py-1" style="width: 65px" >Rp. {{ number_format($detail->discount,0,',','.')  }}</td>
								<td class="py-1" style="width: 65px">Rp. {{ number_format($detail->total,0,',','.') }}</td>
							</tr>
					</table>
					@endforeach
					
				</td>
				<td style="width: 65px">Rp. {{ number_format($order->subtotals)}}</td>
				<td style="width: 65px"> {{ $order->promos !== null ? $order->promos->name . '(' . number_format($order->discount_promo,0,',','.') . ')' : 'Rp. 0' }}</td>
				<td style="width: 65px">Rp. {{ number_format($order->total_price)}}</td>

			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		print();
	</script>
</body>
</html>