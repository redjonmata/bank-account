@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">

                <div class="col-12">
                    <h1>My Account</h1>
                    <hr style="border-top: 1px solid #d9d9d9;">
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="col-md-12 mb-5">
                    <div class="col-md-6">
                        <form method="post" action="/deposit">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="deposit">Deposit amount:</label>
                                <input type="number" name="deposit" step="0.01" class="form-control mb-2" id="deposit" placeholder="Enter deposit amount">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                        <form method="post" action="/withdraw">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Withdraw amount:</label>
                                <input type="number" name="withdraw" step="0.01" class="form-control mb-2" id="withdraw" placeholder="Enter withdraw amount">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>Your current status (balance)</h3>
                    <hr style="border-top: 1px solid #d9d9d9;">
                    <p>Balance: $<span>{{auth()->user()->balance}}</span></p>
                    <p>Overdraft: $<span>{{auth()->user()->overdraft}}</span></p>
                </div>

            </div>
        </div>
    </div>
@endsection
