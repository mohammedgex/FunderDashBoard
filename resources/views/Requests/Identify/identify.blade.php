@extends ('layout')
@section('content')
<h1>Identification</h1>
<div class="container">
  @foreach ($identifications as $identify)
  @if ($identify->status === 'Waiting')
  <div class="card mt-3 w-100" style="border:3px solid rgba(236, 138, 35, 1);">
    @elseif($identify->status === 'not valid')
    <div class="card mt-3 w-100" style="border:3px solid rgba(160, 27, 37, 1);">
      @elseif($identify->status === 'valid')
      <div class="card mt-3 w-100" style="border:3px solid rgba(53, 169, 58, 1);">
        @endif
        <div class="row g-0">
          <div class="col-md-4 border-end border-black">
            <img src="{{url('uploads/'. $identify->front_side)}}" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">username: {{$identify->user->name}}</h5>
              <p class="card-text">{{$identify->type}}</p>
              @if ($identify->status === 'Waiting')
              <p class="card-text" style="color: rgba(236, 138, 35, 1);">{{$identify->status}}</p>
              @elseif($identify->status === 'not valid')
              <p class="card-text" style="color: rgba(160, 27, 37, 1);">{{$identify->status}}</p>
              @elseif($identify->status === 'valid')
              <p class="card-text" style="color: rgba(53, 169, 58, 1);">{{$identify->status}}</p>
              @endif
              <p class="card-text"><small class="text-body-secondary">{{$identify->created_at->formatLocalized('%d %B %Y')}}</small></p>
              <a href="{{route('identify.show', $identify->id)}}" class="btn btn-primary">read more</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endsection