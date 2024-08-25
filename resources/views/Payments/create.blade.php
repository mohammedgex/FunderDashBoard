@extends ('layout')
@section('content')
    <h1>Create Payments</h1>
    <div class="container mt-5">
        <form action="{{ route('payment.create') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="title">
            </div>

            <div class="input-group flex-nowrap my-3">
                <span class="input-group-text" id="description">Description</span>
                <textarea class="form-control" placeholder="Leave a Description here" required name="description" id="floatingTextarea2"
                    style="height: 100px"></textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Bank</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="bank">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Account Number</span>
                <input type="number" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="account_number">
            </div>

            <button class="btn btn-primary" type="submit">Create</button>
        </form>
    </div>

    </div>
@endsection
