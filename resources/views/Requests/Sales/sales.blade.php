@extends ('layout')
@section('content')
    <h1>Request Sales</h1>
    <div class="container">
        @foreach ($sales as $sale)
            @if ($sale->status === 'pending')
                <div class="card mt-3" style="border:3px solid rgba(236, 138, 35, 1);">
                @elseif($sale->status === 'rejected')
                    <div class="card mt-3" style="border:3px solid rgba(160, 27, 37, 1);">
                    @elseif($sale->status === 'accepted')
                        <div class="card mt-3" style="border:3px solid rgba(53, 169, 58, 1);">
            @endif
            <div class="card-body">
                <p>{{ $sale->created_at->formatLocalized('%d %B %Y') }}</p>
                <h3 class="card-title">username : <a
                        href="{{ route('user.show', $sale->user->id) }}">{{ $sale->user->name }}</a></h3>
                <h3 class="card-title">phone: {{ $sale->user->phone }}</h3>
                <h5 class="card-text">property name : <a
                        href="{{ route('property.readMore', $sale->property_id) }}">{{ $sale->property->name }}</a></h5>
                @if ($sale->status === 'pending')
                    <p style="color: rgba(236, 138, 35, 1);" class="my-auto">{{ $sale->status }}</p>
                    <div class="d-flex justify-content-around">
                        <a href="{{ route('sale.rejected', $sale->id) }}" class="btn btn-danger">reject</a>
                        <a href="{{ route('sale.accepted', $sale->id) }}" class="btn btn-success">accept</a>
                    </div>
                @elseif($sale->status === 'rejected')
                    <p style="color: rgba(160, 27, 37, 1);" class="my-auto">{{ $sale->status }}</p>
                @elseif($sale->status === 'accepted')
                    <p style="color: rgba(53, 169, 58, 1);" class="my-auto">{{ $sale->status }}</p>
                @endif

            </div>
    </div>
    @endforeach
    </div>
@endsection
