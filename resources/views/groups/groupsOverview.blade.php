@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Groups</h1>
             @if(session()->has('message'))
                <div class="alert alert-light alert-dismissible" role="alert">
                  <strong>{{ session()->get('message_header') }}!</strong><br>
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif
            <br>
            <br>



            <div class="row">


                    @foreach($groups as $group)
                        @if($group->status == 1)
                            <a href="/groups/{{ $group->id }}">
                                <div class="col-sm-12 col invoice-rows">

                                    {{ $group->name }} <span style="float: right;">{{ $group->sum_of_users }}
                                    </span>

                                </div>
                             </a>
                        @else
                            <a href="#">
                                <div class="col-sm-12 col invoice-rows" style="background-color: rgba(0, 0, 0, 0.28);">

                                    {{ $group->name }} --PENDING--<span style="float: right;">{{ $group->sum_of_users }}
                                    </span>

                                </div>
                            </a>
                        @endif
                    @endforeach
            </div>

            <div>
                <h2 style="text-align: center;">
                    <a  href="/groups/create" class="btn btn-success btn-lg">Create group</a>
                </h2>
            </div>


        </div>
    </div>
</div>
@endsection