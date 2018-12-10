@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 style="text-align: right;"><a href="/products" class="btn btn-sm btn-danger" style="font-weight: bold;">-back to products</a></h2>
            <h1>Products</h1>
             @if(session()->has('message'))
                <div class="alert alert-light alert-dismissible" role="alert">
                  <strong>{{ session()->get('message_header') }}!</strong><br>
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif
            <form role="form" method="post" action="/products/{{ $products->id }}" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group" style="">
                    <label for="name">
                        Product Name:</label>
                    <input type="text" value="{{ $products->name }}" class="form-control" id="name" name="name" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="description">
                        Product Description:</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description" required >{{ $products->description }}
                    </textarea>
                </div>

                <div class="form-group" style="">
                    <label for="promo">
                        Product Promo:</label>
                    <input type="text" value="{{ $products->promo }}" class="form-control" id="promo" name="promo" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="price">
                        Product Price:</label>
                    <input type="number" value="{{ $products->price }}" class="form-control" id="price" name="price" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="stock">
                        Product Stock:</label>
                    <input type="number" value="{{ $products->stock }}" class="form-control" id="stock" name="stock" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="file">
                        Product image: <a id="removeB" onclick="
                        document.getElementById('productimage').style.display = 'none';
                        document.getElementById('removeB').style.display = 'none';
                        document.getElementById('file_input').style.display = 'block';
                        document.getElementById('file_input').setAttribute('type', 'file');

                        " class="btn btn-sm btn-danger">X</a></label>
                        <div>
                            <img id="productimage"  src="{{ Storage::url($products->file) }}" style="width: 100%;">
                        </div>
                    <input style="display: none;" type="text" value="{{$products->file}}" class="form-control" id="file_input" name="file" accept="image/*" required>
                </div>

                <input style="display: none;" type="hidden" value="1" class="form-control" id="file_input_option" name="fileOption">

                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                                UPDATE
                            </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection