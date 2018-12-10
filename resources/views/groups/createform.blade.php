@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-block">
            <h2 style="text-align: right;"><a href="/groups" class="btn btn-sm btn-danger" style="font-weight: bold;">-back to groups</a></h2>
            <h1>Create a new Group</h1>
            @if(session()->has('message'))
                <div class="alert alert-light alert-dismissible" role="alert">
                  <strong>{{ session()->get('message_header') }}!</strong><br>
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif
            <form role="form" method="post" action="/groups">
                {{ csrf_field() }}

                <div class="form-group" style="">
                    <label for="name">
                        Group Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="description">
                        Group Description:</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description" required ></textarea>
                </div>

                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                        CREATE group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection