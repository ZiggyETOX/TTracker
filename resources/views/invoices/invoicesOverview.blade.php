@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Invoices</h1>
            <h2>
                <a href="/transactions/create" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             Transaction
                </a>
            </h2>
            <br>
            <br>

            <div class="row">
                @foreach($invoices as $invoice)
                <a href="/invoices/{{ $invoice->id }}">
                <div class="col-sm-12 col invoice-rows">

                        {{ $invoice->name }}

                        @if($invoice->change > 0)
                        <span style="float: right;color:green;">
                            {{ $invoice->change }}
                        </span>
                        @else
                        <span style="float: right;color:red;">
                            {{ $invoice->change }}
                        </span>
                        @endif

                         <!-- <span style="float: right;">{{ $invoice->sum_of_transactions }}
                        </span>
 -->
                </div>
                 </a>
                @endforeach
            </div>


        </div>
    </div>
</div>
@endsection