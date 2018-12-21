@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Invoices for <b>{{ $group->name }}</b></h1>
             @if(session()->has('message'))
                <div class="alert alert-light alert-dismissible" role="alert">
                  <strong>{{ session()->get('message_header') }}!</strong><br>
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif
            <h2>
                <a href="/groups/{{ $group->id }}/invite" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             Invite friend to join this group
                </a>
                <a href="/transactions/create" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             Transaction
                </a>
            </h2>
            Your combined total balance is: R {{ $groupBalance }}
            <a href="/groups/{{ $group->id }}/transactions" class="btn btn-sm btn-success" style="font-weight: bold;">show all group transactions</a>
            <br>
            <br>



            <div class="row">
                @foreach($invoices as $invoice)
                <a href="/groups/{{ $group->id }}/invoices/{{ $invoice->name }}">
                <div class="col-sm-12 col invoice-rows">

                        {{ $invoice->name }}
                        @if($invoice->change > 0)
                            <span style="float: right;color:green;">
                                &#43;{{ $invoice->change }}
                            </span><br>
                            @if($invoice->balance > 0)
                                <span style="float: right;color:green;">
                                    {{ $invoice->balance }}
                                </span>
                            @else
                                <span style="float: right;color:red;">
                                    {{ $invoice->balance }}
                                </span>
                            @endif
                        @else
                        <span style="float: right;color:red;">
                            {{ $invoice->change }}
                        </span><br>
                            @if($invoice->balance > 0)
                                <span style="float: right;color:green;">
                                    {{ $invoice->balance }}
                                </span>
                            @else
                                <span style="float: right;color:red;">
                                    {{ $invoice->balance }}
                                </span>
                            @endif
                        @endif


                </div>
                 </a>
                @endforeach
            </div>


        </div>
    </div>
</div>
@endsection