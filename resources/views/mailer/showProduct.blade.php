@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 style="text-align: right;"><a href="/products" class="btn btn-sm btn-danger" style="font-weight: bold;">-back to products</a></h2>
            <h1>Products</h1>
            <table class='table table-striped'>
            	<thead>
            		<tr>
            			<th>Name</th>
                        <th>Promo</th>
            			<th>Price</th>
            			<th>Stock</th>
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>

            		<tr>
            			<td>{{ $products->name }}</td>
                        <td>{{ $products->promo }}</td>
            			<td>{{ $products->price }}</td>
                        <td>{{ $products->stock }}</td>
            			<td style="text-align: right;">
                            <!-- <a href="/products/{{$products->id}}" class="btn btn-sm btn-success" style="display: inline-block;">Show</a> -->
                            <a href="/products/{{$products->id}}/edit" class="btn btn-sm btn-primary" style="display: inline-block;">Edit</a>

                            <form method="post" action="/products/{{ $products->id }}" style="display: inline-block;">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-danger" style="display: inline-block;">
                                X
                            </button>
                            </form>
            			</td>
            		</tr>
            	</tbody>
            </table>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                           <img src="{{ Storage::url($products->file) }}" style="width: 100%;">
                        </td>
                        <td style="width: 50%;">
                            {{ $products->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection