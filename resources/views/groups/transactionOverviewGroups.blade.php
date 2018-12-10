@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             <h2 style="text-align: right;"><button onclick="window.history.back();" class="btn btn-sm btn-danger" style="font-weight: bold;">-back</button></h2>
            <h1>Transactions for {{ $group->name }} group and in {{ $invoice->name }}</h1>
            <!-- <h2>
                <a href="/transactions/create" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             TRANSACTION
                </a>
            </h2> -->
            <table class="table responsive table-striped" id="sort">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">TransactionBY</th>
                        <th scope="col">Type</th>
                        <th scope="col">Change</th>
                        <th scope="col">Balance<span style="float: right;">{{ $invoice->myBalance }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)

                    <tr id="/transactions/{{$transaction->id}}/edit" onclick="clicker(this);" class="myrow"

                     @php
                            if ($transaction->type == "income"){
                                $change = $transaction->amount;
                                $invoice->myBalance += $transaction->amount;
                                echo(" style='background:rgba(42,178,123,0.3);'");
                            }else{
                                $change = -1;
                                $invoice->myBalance -= $transaction->amount;
                                echo(" style='background:rgba(191,83,41,0.3);'");
                            }
                    @endphp
                    >
                        <td data-table-header="Date">{{ $transaction->date }}</td>
                        <td data-table-header="TransactionBY" style="font-weight: bold;font-size: 18px;">
                            {{ $transaction->owner }}</td>
                        <td data-table-header="Type">{{ $transaction->transaction_sub_type->name }}</td>
                        <td data-table-header="Change">

                        @if($change > 0)

                        <span class="plus indicators">+</span>
                        <span class="plus change">{{ $change }}</span>
                        @else

                        <span class="minus indicators">-</span>
                        <span class="minus change">{{ $transaction->amount }}</span>
                        @endif
                        </td>
                        <td data-table-header="Balance">R<span style="float: right;">{{ $invoice->myBalance }}</span></td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Balance</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($invoice->myBalance > -1)
                        <td style="background-color: rgba(42, 178, 123, 1); color: #FFFFFF;font-weight: bold;">
                            R<span style="float: right;">{{ $invoice->myBalance }}</span>
                        </td>
                        @else
                        <td style="background-color: rgba(191, 83, 41, 1); color: #FFFFFF;font-weight: bold;">
                            R<span style="float: right;">{{ $invoice->myBalance }}</span>
                        </td>
                        @endif
                    </tr>
                </tbody>
            </table> -->
        </div>
    </div>
</div>
@endsection