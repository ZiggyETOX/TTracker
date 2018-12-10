@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-block">
            <h2>
                <a href="/transactions/{{$transaction->id}}" class="btn btn-md btn-success" style="font-weight: bold;float: left;">
                    Duplicate
                </a>
                <button onclick="window.history.back();" class="btn btn-sm btn-danger" style="font-weight: bold;float: right;">-back</button>
            </h2>
            <br>
            <h1>Transactions</h1>
            @if(session()->has('message'))
                <div class="alert alert-light alert-dismissible" role="alert">
                  <strong>{{ session()->get('message_header') }}!</strong><br>
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif
            <form role="form" method="post" action="/transactions/{{ $transaction->id }}" enctype="multipart/form-data">

                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group" style="">
                    <label for="name">
                        TransactionBY:</label>
                    <input type="text" value="{{ $transaction->name }}" class="form-control" id="name" name="name" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="date">
                       Transaction date:</label>
                    <input type="date" value="{{ $transaction->date }}" class="form-control" id="date" name="date" required ></input>
                </div>

                <div class="form-group" style="">
                    <label for="sellectType">
                        Transaction Type:</label>
                        <select required="required" onchange="checkType(this);" class="form-control" name="sellectType" id="typeSelect">
                          @if($transaction->type == "income")
                          <option selected="selected" value="income">Income</option>
                          <option value="expense">Expense</option>
                          @else
                          <option selected="selected" value="expense">Expense</option>
                          <option value="income">Income</option>
                          @endif
                        </select>
                    <input type="text" style="opacity: 0;height: 0px;padding: 0;" required="" class="form-control" id="type" name="type" value="{{ $transaction->type }}">
                </div>

                <div class="form-group" style="">
                    <label for="sellectSubType">
                        Transaction Subtype:</label>
                        <div id="sellectSubType">
                            <select required="required" onchange="yesnoCheck(this);" id="subtypeSelect" class="form-control" name="sellectSubType">
                                <option id="selectT" selected="selected" disabled="true" value=" ">{{ $transaction->transaction_sub_type->name }}</option>
                            </select>
                            <input type="text" style="opacity: 0;height: 0px;padding: 0;" placeholder="add new type" class="form-control" id="subtype" name="subtype" required="required" value="{{ $transaction->transactionsub_types_id }}">
                        </div>
                </div>

                <div class="form-group" style="">
                    <label for="amount">
                        Transaction Amount:</label>
                    <input type="number" value="{{ $transaction->amount }}" class="form-control" id="amount" name="amount" required>
                </div>

                <div class="form-group" style="">
                    <label for="pb">
                        Personal/Business:</label>
                    <select required class="form-control" name="pb">

                          @if($transaction->pb == "business")
                          <option selected="selected" value="business">Business</option>
                          <option value="personal">Personal</option>
                          @else
                          <option selected="selected" value="personal">Personal</option>
                          <option value="business">Business</option>
                          @endif
                    </select>
                </div>

                <div class="form-group" style="">
                    <label for="description">
                        Transaction Description:</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description" required >{{ $transaction->description }}</textarea>
                </div>

                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                        Update Transaction
                    </button>
                </div>
            </form>
            <form method="post" id="deleteF" style="display: inline-block;">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button id="deleteBtn" onclick="deleteF(this);" class="btn btn-sm btn-danger" style="display: inline-block;">
                    DELETE
                </button>
            </form>
            <script type="text/javascript">
                function deleteF(that){

                    var r = confirm('Are you sure you want to delete this transaction?');
                    if (r == true) {
                        document.getElementById('deleteF').setAttribute("action","/transactions/{{ $transaction->id }}");
                        that.submit();
                    } else {

                    }
                }
            </script>

        </div>
    </div>
</div>

                <script type="text/javascript">




                    var expenseTypes = "";
                    @foreach($expensesubtypes as $expensesubtype)
                     @if ($transaction->transaction_sub_type->name == $expensesubtype->name)
                       expenseTypes += "<option selected='selected' value='{{ $expensesubtype->id }}'>{{ $expensesubtype->name }}</option>";

                     @else
                       expenseTypes += "<option value='{{ $expensesubtype->id }}'>{{ $expensesubtype->name }}</option>";
                     @endif
                    @endforeach

                    var incomeTypes ="";
                    @foreach($incomesubtypes as $incomesubtype)
                        @if ($transaction->transaction_sub_type->name == $incomesubtype->name)

                        incomeTypes += "<option selected='selected' value='{{ $incomesubtype->id }}'>{{ $incomesubtype->name }}</option>";
                        @else
                        incomeTypes += "<option value='{{ $incomesubtype->id }}'>{{ $incomesubtype->name }}</option>";
                        @endif
                    @endforeach

                    document.getElementById('subtypeSelect').onchange();
                    document.getElementById('typeSelect').onchange();

                    function checkType(that){

                        document.getElementById('subtypeSelect').removeAttribute("disabled");
                        document.getElementById('type').setAttribute("value",that.value);

                        if (that.value == "income") {
                            document.getElementById('subtypeSelect').innerHTML
                            = incomeTypes + "<option value='other'>Other</option>";
                        }
                        else{
                            document.getElementById('subtypeSelect').innerHTML
                            = expenseTypes + "<option value='other'>Other</option>";
                        }

                    document.getElementById('subtypeSelect').onchange();
                    }

                    function yesnoCheck(that){




                        if (that.value == "other") {
                            document.getElementById('subtype').setAttribute("style","margin-top:15px");
                            document.getElementById('subtype').setAttribute("value","");
                        }
                        else{
                            document.getElementById('subtype').setAttribute("value",that.value);
                            document.getElementById('subtype').setAttribute("style","visibility: hidden;height: 0px;padding: 0;");
                        }
                    }

                </script>
@endsection