@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Products</h1>
            <h2>
                <a href="/products/create" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             PRODUCT
                </a>
            </h2>
            <table class='table table-striped'>
            	<thead>
            		<tr>
            			<th>Name</th>
            			<!-- <th>Price</th>
            			<th>Stock</th> -->
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>
            		@foreach($products as $product)
            		<tr>
            			<td>{{ $product->name }}</td>
            			<!-- <td>{{ $product->price }}</td>
            			<td>{{ $product->stock }}</td> -->
            			<td style="text-align: right;">
                            <a href="/products/{{$product->id}}" class="btn btn-sm btn-success" style="display: inline-block;">Show</a>
                            <a href="/products/{{$product->id}}/edit" class="btn btn-sm btn-primary" style="display: inline-block;">Edit</a>

                            <form method="post" action="/products/{{ $product->id }}" style="display: inline-block;">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-danger" style="display: inline-block;">
                                X
                            </button>
                            </form>
            			</td>
            		</tr>
            		@endforeach
            	</tbody>
            </table>
        </div>
    </div>
</div>
@endsection