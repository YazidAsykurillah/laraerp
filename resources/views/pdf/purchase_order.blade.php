<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $purchase_order->code }}</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>{{ $purchase_order->code }}</h1>
				<table class="table table-bodered table-striped">
					<thead>
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Units</th>
							<th>Price</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($purchase_order->products as $product)
						<tr>
							<td>{{ $product->name }}</td>
							<td>{{ $product->pivot->quantity }}</td>
							<td>{{ $product->unit->name }}</td>
							<td>{{ number_format($product->pivot->price) }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3">Total</th>
							<th> {{ number_format($total_price) }}</th>
						</tr>
					</tfoot>
					
				</table>	
			</div>
		</div>
		<p></p>


		<div class="row">
			<table style="width:60%;border:0px;margin-left:12px;">
				<tr>
					<td>Supplier</td>
					<td>:</td>
					<td>{{ $purchase_order->supplier->name }}</td>
				</tr>
				<tr>
					<td>Created Date</td>
					<td>:</td>
					<td>{{ $purchase_order->created_at }}</td>
				</tr>
				<tr>
					<td>Created By</td>
					<td>:</td>
					<td>{{ $purchase_order->created_by->name }}</td>
				</tr>
				<tr>
					<td>Status</td>
					<td>:</td>
					<td>{{ $purchase_order->status }}</td>
				</tr>


			</table>
		</div>
		
	</div>
	
</body>

</html>