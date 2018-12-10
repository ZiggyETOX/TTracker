@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Products</h1>
            <table class='table table-striped'>
            	<thead>
            		<tr>
            			<th>Name</th>
            			<th>Price</th>
            			<th>Stock</th>
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>
            		@foreach($products as $product)
            		<tr>
            			<td>{{ $product->name }}</td>
            			<td>{{ $product->price }}</td>
            			<td>{{ $product->stock }}</td>
            			<td>
            				<a href="/product/{{$product->id}}" class="btn btn-sm btn-primary">Edit</a>
            			</td>
            		</tr>
            		@endforeach
            	</tbody>
            </table>
        </div>
    </div>
</div>
@endsection