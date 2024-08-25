@extends ('layout')
@section('content')
    <h1>property shered user : {{ $user->name }}</h1>
    <div class="container mt-5 d-flex justify-content-between">
        @if (count($properties) > 0)
            @foreach ($properties as $property)
                <div class="card" style="width: 18rem;">
                    <img src="{{ url('uploads/' . $property->images[0]) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">property name:
                            <a href="{{ route('property.readMore', $property->id) }}">{{ $property->name }}</a>
                        </h5>
                        <p class="card-text">shere funder:
                            {{ App\Models\Funder::where(['status' => 'funder', 'user_id' => $user->id, 'property_id' => $property->id])->count() }}
                        </p>
                        <p class="card-text">shere pending:
                            {{ App\Models\Funder::where(['status' => 'pending', 'user_id' => $user->id, 'property_id' => $property->id])->count() }}
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <h1>nothing</h1>
        @endif
    </div>
@endsection
