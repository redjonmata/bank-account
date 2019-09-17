@extends('layouts.app')
@section('title', 'My Transactions')

@section('content')
<div class="container" id="home-container">
    <div class="row justify-content-center align-items-center pt-4">

        <div class="col-12 col-md-10 col-lg-10 ">
            <h4 class="form-heading text-center"> My Transactions</h4>
            <div class="example table-responsive">
                <table class="table">
                    <thead class="thead-success">
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    @foreach($transactions as $transaction)
                        <tbody>
                        <tr>
                            <td class="alignment">{{ ucfirst($transaction->type) }}</td>
                            <td class="alignment">${{ $transaction->amount }}</td>
                            <td class="alignment">{{ date('d M. Y', strtotime($transaction->created_at)) }}</td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

