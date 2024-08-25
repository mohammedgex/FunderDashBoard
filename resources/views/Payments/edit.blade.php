@extends ('layout')
@section('content')
    <h1>Edit Payments: {{ $payment->title }}</h1>
    <div class="container mt-5">
        <form action="{{ route('payment.update', $payment->id) }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="title" value="{{ $payment->title }}">
            </div>

            <div class="input-group flex-nowrap my-3">
                <span class="input-group-text" id="description">Description</span>
                <textarea class="form-control" placeholder="Leave a Description here" required name="description" id="floatingTextarea2"
                    style="height: 100px">{{ $payment->description }}</textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Bank</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="bank" value="{{ $payment->bank }}">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Account Number</span>
                <input type="number" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default"
                    name="account_number"value="{{ $payment->account_number }}">
            </div>

            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
@endsection
