@extends ('layout')
@section('content')
    <h1>Property name: <a href="{{ route('property.readMore', $property->id) }}">{{ $property->name }}</a></h1>
    <div class="container">
        <form action="{{ url()->previous() }}" class="d-flex justify-content-around my-3" method="GET">
            <button type="submit" class="btn btn-primary btn-sm">Go Back</button>
        </form>
        <div class="my-4">
            <h3>property shares count: <span class="text-success">{{ $property->funder_count }}</span> share and <span
                    class="text-warning">{{ $property->funder_count * (1 / 5) }}</span> pending</h3>
            <h3>Purchased shares: <span class="text-success">{{ count($shares->where('status', 'funder')) }}</span> share
                and <span class="text-warning">{{ count($shares->where('status', 'pending')) }}</span> pending</h3>
        </div>
        @if (count($shares) > 0)
            @foreach ($shares as $share)
                <div class="card mb-3 w-100">
                    <div class="row g-0">
                        <div class="col-md-4 border-end border-black">
                            <img src="{{ url('uploads/' . $share->user->image) }}" class="img-fluid rounded-start"
                                alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">username: <a
                                        href="{{ route('user.show', $share->user->id) }}">{{ $share->user->name }}</a></h5>
                                @if ($share->status == 'funder')
                                    <p class="card-text text-success">{{ $share->status }}</p>
                                @else
                                    <p class="card-text text-warning">{{ $share->status }}</p>
                                @endif
                                <p class="card-text">{{ $share->user->email }}</p>
                                <p class="card-text"><small
                                        class="text-body-secondary">{{ $share->created_at->formatLocalized('%d %B %Y') }}</small>
                                </p>
                                <a href="{{ route('property.shares.delete', $share->id) }}"
                                    class="btn btn-primary">delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h1 class="mt-4">There are no contributors yet</h1>
        @endif
    </div>
@endsection
