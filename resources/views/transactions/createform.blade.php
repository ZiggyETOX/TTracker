@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-block">
            <h2 style="text-align: right;"><button onclick="window.history.back();" class="btn btn-sm btn-danger" style="font-weight: bold;">-back</button></h2>
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
            <form role="form" method="post" action="/transactions" enctype="multipart/form-data">


                {{ csrf_field() }}
                <div class="form-group" style="">
                    <label for="name">
                        Transaction BY:</label>
                    <input type="text" placeholder="Name the transaction" class="form-control" id="name" name="name" value="{{ $user->name }}" required maxlength="255">
                </div>

                <div class="form-group" style="">
                    <label for="date">
                       Transaction date:</label>
                    <input type="date" class="form-control" id="date" name="date" required ></input>
                </div>

                <div class="form-group" style="">
                    <label for="sellectType">
                        Transaction Type:</label>
                        <select required="required" onchange="checkType(this);" class="form-control" name="sellectType" id="typeSelect">
                          <option id="selectT" selected="selected" disabled="true"> --SELECT-- </option>
                          <option value="income">Income</option>
                          <option value="expense">Expense</option>
                        </select>
                    <input type="text" style="opacity: 0;height: 0px;padding: 0;" required="" class="form-control" id="type" name="type" value="">
                </div>

                <div class="form-group" style="">
                    <label for="sellectSubType">
                        Transaction Subtype:</label>
                        <div id="sellectSubType">
                            <select disabled="disabled" required="required" onchange="yesnoCheck(this);" id="subtypeSelect" class="form-control" name="sellectSubType">
                                <option id="selectT" selected="selected" disabled="true" value=" "> --SELECT-- </option>
                            </select>
                            <br>
                            <input type="text" style="opacity: 0;height: 0px;padding: 0;" placeholder="add new type" class="form-control" id="subtype" name="subtype" required="required" value="">
                        </div>
                </div>

                <div class="form-group" style="">
                    <label for="amount">
                        Transaction Amount:</label>
                    <input type="number" placeholder="R" class="form-control" id="amount" name="amount" required>
                </div>

                <div class="form-group" style="">
                    <label for="pb">
                        Personal/Business:</label>
                    <select required class="form-control" name="pb">
                      <!-- <option selected="selected" disabled="true" value=" "> --SELECT-- </option> -->
                      <option value="business">Business</option>
                      <option value="personal">Personal</option>
                    </select>
                </div>

                <div class="form-group" style="">
                    <label for="description">
                        Transaction Description:</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description" required ></textarea>
                </div>

                <div class="form-group" style="">
                    <button type="submit" class="btn btn-lg btn-success" id="btnSubmitEntry">
                        ADD transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                <script type="text/javascript">

                    var expenseTypes = "";
                    @foreach($expensesubtypes as $expensesubtype)
                    expenseTypes += "<option value='{{ $expensesubtype->id }}'>{{ $expensesubtype->name }}</option>";
                    @endforeach

                    var incomeTypes ="";
                    @foreach($incomesubtypes as $incomesubtype)
                    incomeTypes += "<option value='{{ $incomesubtype->id }}'>{{ $incomesubtype->name }}</option>";
                    @endforeach

                    function checkType(that){

                        document.getElementById('subtypeSelect').removeAttribute("disabled");
                        document.getElementById('type').setAttribute("value",that.value);

                        if (that.value == "income") {
                            document.getElementById('subtypeSelect').innerHTML
                            = "<option selected='selected' disabled='true' value> --SELECT-- </option>" + incomeTypes + "<option value='other'>Other</option>";
                        }
                        else{
                            document.getElementById('subtypeSelect').innerHTML
                            = "<option selected='selected' disabled='true' value> --SELECT-- </option>" + expenseTypes + "<option value='other'>Other</option>";
                        }
                    }

                    function yesnoCheck(that){



                        if (that.value == "other") {
                            document.getElementById('subtype').setAttribute("style","");
                            document.getElementById('subtype').setAttribute("value","");
                        }
                        else{
                            document.getElementById('subtype').setAttribute("value",that.value);
                            document.getElementById('subtype').setAttribute("style","visibility: hidden;height: 0px;padding: 0;");
                        }
                    }

                </script>
@endsection