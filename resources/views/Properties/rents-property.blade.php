@extends ('layout')
@section('content')
    <h1>Rents</h1>
    <a class="btn btn-primary" href="{{ route('rent.add', $property) }}">create rent</a>
    <div class="container mt-5">
        @foreach ($rents as $rent)
            <div class="card mb-4">
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>status: {{ $rent->status }}</p>
                        <p>Monthly Income: {{ $rent->monthly_income }}</p>
                        <footer class="blockquote-footer">Start date : <cite
                                title="Source Title">{{ $rent->start_date }}</cite>
                        </footer>
                        <footer class="blockquote-footer">end date : <cite title="Source Title">{{ $rent->end_date }}</cite>
                        </footer>
                    </blockquote>
                </div>
                <div class="my-3 d-flex justify-content-around">
                    @if ($rent->status == 'not active')
                        <a class="btn btn-primary" href="{{ route('rent.active', $rent->id) }}">active</a>
                    @elseif($rent->status == 'active')
                        <a class="btn btn-danger" href="{{ route('rent.not-active', $rent->id) }}">not active</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
