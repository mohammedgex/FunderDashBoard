@extends ('layout')
@section('content')
    <h1>Property name {{ $property->name }}</h1>
    <div class="d-flex justify-content-around my-3 flex-wrap gap-3">
        <a class="btn btn-primary btn-sm" href="{{ route('timeline.index', $property->id) }}">create timeline</a>
        @if ($property->status != 'sold out')
            <a href="{{ route('property.gosoldout', $property->id) }}" class="btn btn-primary btn-sm">sold out</a>
        @endif
        <a href="{{ route('property.shares', $property->id) }}" class="btn btn-primary btn-sm">shares</a>
        <a href="{{ route('property.edit', $property->id) }}" class="btn btn-primary btn-sm">edit</a>
        <a href="{{ route('rent.show', $property->id) }}" class="btn btn-primary btn-sm">rents</a>
        <form action="{{ route('property.delete', $property->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input class="btn btn-danger btn-sm" type="submit" value="delete">
        </form>
    </div>
    <div class="slideshow-container border border-black">
        @foreach ($property->images as $key => $image)
            <div class="mySlides faded">
                <div class="numbertext">{{ $key + 1 }} / {{ count($property->images) }}</div>
                @if (count($property->images) > 1)
                    <a class="btn btn-danger btn-sm" style="position: absolute; right: 10px; top: 10px;"
                        href="{{ route('property.image.delete', ['id' => $property->id, 'imagename' => $image]) }}">delete
                        image</a>
                @endif
                <img src="{{ url('uploads/' . $image) }}" style="width:100%">
            </div>
        @endforeach
        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>
    <!-- The dots/circles -->
    <div style="text-align:center">
        @for ($i = 0; $i < count($property->images); $i++)
            <span class="dot" onclick='currentSlide({{ $i + 1 }})'></span>
        @endfor
    </div>
    <hr>
    <p>{{ $property->description }}</p>
    <hr>
    <p>estimated Annualised return = {{ $property->estimated_annualised_return }}%</p>
    <p>estimated Annual appreciation = {{ $property->estimated_annual_appreciation }}%</p>
    <p>estimated projected gross yield = {{ $property->estimated_projected_gross_yield }}%</p>
    <p>annual gross yield = {{ $property->percent }}%</p>
    <hr>
    <p>funded date = {{ $property->funded_date }}</p>
    <hr>
    <p>current rent = {{ $property->current_rent }}</p>
    <p>Service charge = {{ $property->service_charge }}</p>
    <p>rental income paid = {{ $property->rental_income }}</p>
    <p>purchase price = {{ $property->purchase_price }}</p>
    <p>property price = {{ $property->property_price_total }}</p>
    <p>share price = {{ $property->property_price }}</p>
    <hr>
    @if ($property->timelines->count() > 0)
        <div class="timeline">
            <h3 class="mb-5">timelines</h3>
            @foreach ($property->timelines as $timeline)
                <div class="mt-3">
                    <h3>{{ $timeline->date }}</h3>
                    <h1>{{ $timeline->title }}</h1>
                    <p>{{ $timeline->description }}</p>
                    <div class="d-flex justify-content-around">
                        <a href="{{ route('timeline.delete', $timeline->id) }}" class="btn btn-danger btn-sm">delete</a>
                        <a href="{{ route('timeline.edit', $timeline->id) }}" class="btn btn-primary btn-sm">edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>
@endsection
