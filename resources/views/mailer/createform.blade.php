@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-block">
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
            <form role="form" method="post" action="/products" enctype="multipart/form-data">


                {{ csrf_field() }}
                <div class="form-group" style="">
                    <label for="name">
                        Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="description">
                        Product Description:</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description" required ></textarea>
                </div>

                <div class="form-group" style="">
                    <label for="promo">
                        Product Promo:</label>
                    <input type="text" class="form-control" id="promo" name="promo" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="price">
                        Product Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="stock">
                        Product Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="file">
                        Product image:</label>
                    <input type="file" class="form-control" id="file_input" name="file" accept="image/*" required >
                </div>

                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                                ADD PRODUCT
                            </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection