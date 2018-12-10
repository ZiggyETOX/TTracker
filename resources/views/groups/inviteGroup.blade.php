@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-block">
            <h2 style="text-align: right;"><button onclick="window.history.back();" class="btn btn-sm btn-danger" style="font-weight: bold;">-back</button></h2>
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
            <form role="form" method="post" action="/groups/{{ $group->id }}/invite/send">
                {{ csrf_field() }}

                <div class="form-group" style="">
                    <label for="email">
                        friend's email:</label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="message">
                        Message:</label>
                    <textarea type="text" rows="4" class="form-control" id="message" name="message" required ></textarea>
                </div>
                <input type="hidden" name="user_name" value="{{ $user->name }}">

                <input type="hidden" name="group_name" value="{{ $group->name }}">


                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                        Invite Friend
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection