@extends('layouts.app')

@section('content')
<div class="container">

    <!-- display banner and top text -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Banner and Top text</h1>

            <input type="" name="">
        </div>
    </div>

    <hr>

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Products</h1>
            <h2><a href="/products/create" class="btn btn-sm btn-success" style="font-weight: bold;">ADD product</a></h2>

            <!--Accordion wrapper-->
            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

              @foreach($products as $product)
              <!-- Accordion card -->
              <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="heading{{ $product->id }}">
                  <a data-toggle="collapse" data-parent="#accordionEx" href="#collapse{{ $product->id }}" aria-expanded="true" aria-controls="collapse{{ $product->id }}" style="text-decoration: none;">
                    <h5 class="mb-0" style="
                      background-color: #61a0b9;
                      width: 100%;
                      padding: 15px;
                      color: #FFFFFF;
                      font-weight: bold;
                      border-radius: 5px;
                      ">
                      Collapsible Group Item #{{ $product->id }} <i class="fa fa-angle-down rotate-icon"></i>
                    </h5>
                  </a>
                </div>

                <!-- Card body -->
                <div id="collapse{{ $product->id }}" class="collapse" role="tabpanel" aria-labelledby="heading{{ $product->id }}" data-parent="#accordionEx">
                  <div class="card-body">
                    <table class='table table-striped'>
                        <tbody>
                            <tr>
                                <td>
                                    <td style="width: 50%;">
                                       <img src="{{ Storage::url($product->file) }}" style="width: 100%;">
                                    </td>
                                </td>
                                <td style="width: 50%;">
                                    <table class='table table-striped'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $product->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $product->description }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $product->promo }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $product->price }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $product->stock }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-custom">BUY!</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <!-- Accordion card -->
              @endforeach

            </div>
            <!-- Accordion wrapper -->
           <!--  <table class='table table-striped'>
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
 -->        </div>
    </div>
</div>
@endsection