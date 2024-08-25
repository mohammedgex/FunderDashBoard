@extends ('layout')
@section('content')
    <h1>create rent<h1>
            <div class="container mt-5">
                <form action="{{ route('rent.create', $property_id) }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">start date</span>
                        <input type="date" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="start_date">
                    </div>
                    @error('start_date')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Monthly Income</span>
                        <input type="number" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="monthly_income">
                    </div>
                    @error('monthly_income')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">end date</span>
                        <input type="date" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="end_date">
                    </div>
                    @error('end_date')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        @endsection
