@extends ('layout')
@section('content')
    <h1>Payments</h1>
    <div class="container mt-5">
        @foreach ($payments as $payment)
            <div class="card">
                <div class="card-header">
                    payment method : {{ $payment->title }}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $payment->description }}.</p>
                        <footer class="blockquote-footer">bank : <cite title="Source Title">{{ $payment->bank }}</cite>
                        </footer>
                        <footer class="blockquote-footer">Account number : <cite
                                title="Source Title">{{ $payment->account_number }}</cite>
                        </footer>
                    </blockquote>
                </div>
                <div class="my-3 d-flex justify-content-around">
                    <a class="btn btn-primary" href="{{ route('payment.edit', $payment->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ route('payment.delete', $payment->id) }}">Delete</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
