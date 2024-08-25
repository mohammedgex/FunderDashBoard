@extends ('layout')
@section('content')
    <h1>Properties</h1>
    <div class="container mt-4">
        <div class="d-flex justify-content-around">
            <div class="">
                <a class="btn btn-primary btn-sm" href="{{ route('property.soldout') }}">sold out</a>
            </div>
            <div class="">
                <a class="btn btn-primary btn-sm" href="{{ route('property.index') }}">all</a>
            </div>
            <div class="">
                <a class="btn btn-primary btn-sm" href="{{ route('property.available') }}">available</a>
            </div>
        </div>

        @if (count($properties) == 0)
            <h1>There are no property</h1>
        @else
            <div class="d-flex gap-5 mt-5 flex-wrap justify-content-center">
                @foreach ($properties as $property)
                    <div class="card" style="width: 18rem;">
                        <img src="{{ url('uploads/' . $property->images[0]) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->name }}</h5>
                            <p class="card-text text-truncate">{{ $property->description }}</p>
                            @if ($property->status == 'sold out' && $property->approved != null)
                                <p class="card-text text-danger">rented</p>
                            @elseif($property->status == 'sold out')
                                <p class="card-text text-danger">sold out</p>
                            @endif
                            <a href="{{ route('property.readMore', $property->id) }}" class="btn btn-primary">read more</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
