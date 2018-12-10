@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Product displaying in a list -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             <h2 style="text-align: right;"><button onclick="window.history.back();" class="btn btn-sm btn-danger" style="font-weight: bold;">-back</button></h2>
            <h1>Transactions</h1>
            <h2>
                <a href="/transactions/create" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">+</span>
             TRANSACTION
                </a>
                <a href="/transactions/download/{{ $user->id }}/{{ $downloadType }}" class="btn btn-sm btn-success" style="font-weight: bold;">
                <span style="font-size: 24px;font-weight: bold;">*</span>
             Download
                </a>
            </h2>
            <table class="table responsive table-striped">
            	<thead>
            		<tr>
            			<th>Date</th>
                        <th>TransactionBY</th>
                        <th>Type</th>
                        <th>Change</th>
            			<th>Balance<span style="float: right;">{{ $balance }}</span></th>
            		</tr>
            	</thead>
            	<tbody>
            		@foreach($transactions as $transaction)

            		<tr id="/transactions/{{$transaction->id}}/edit" onclick="clicker(this);" class="myrow"

                     @php
                            if ($transaction->type == "income"){
                                $change = $transaction->amount;
                                $balance += $transaction->amount;
                                echo(" style='background:rgba(42,178,123,0.3);'");
                            }else{
                                $change = -1;
                                $balance -= $transaction->amount;
                                echo(" style='background:rgba(191,83,41,0.3);'");
                            }
                    @endphp
                    >
            			<td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->transaction_sub_type->name }}</td>
            			<td>

                        @if($change > 0)

                        <span class="plus indicators">+</span>
                        <span class="plus change">{{ $change }}</span>
                        @else

                        <span class="minus indicators">-</span>
                        <span class="minus change">{{ $transaction->amount }}</span>
                        @endif
                        </td>
                        <td>R<span style="float: right;">{{ $balance }}</span></td>

            		</tr>
            		@endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($balance > -1)
                        <td style="background-color: rgba(42, 178, 123, 1); color: #FFFFFF;font-weight: bold;">
                            R<span style="float: right;">{{ $balance }}</span>
                        </td>
                        @else
                        <td style="background-color: rgba(191, 83, 41, 1); color: #FFFFFF;font-weight: bold;">
                            R<span style="float: right;">{{ $balance }}</span>
                        </td>
                        @endif
                    </tr>
            	</tbody>
            </table>
        </div>
    </div>
</div>
@endsection