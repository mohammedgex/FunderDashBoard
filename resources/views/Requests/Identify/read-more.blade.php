@extends ('layout')
@section('content')
<h1>Identification</h1>
<div class="container">
  <h1>username: <a href="{{route('user.show', $identify->user->id)}}"> {{$identify->user->name}} </a></h1>
  <div class="image w-75 mx-auto my-5 border border-black">
    <img class="image w-100" src="{{url('uploads/'.$identify->front_side)}}" alt="..">
  </div>
  <div class="image w-75 mx-auto my-5 border border-black">
    <img class="image w-100" src="{{url('uploads/'.$identify->back_side)}}" alt="..">
  </div>
  <h3>type: {{$identify->type}}</h3>
  <h3>date: {{\Carbon\Carbon::parse($identify->creates_at)->isoFormat('D MMMM YYYY')}}</h3>
  @if ($identify->status === 'Waiting')
  <h3 style="color: rgba(236, 138, 35, 1);"><span class="text-black">status:</span> {{$identify->status}}</h3>
  <div class="d-flex justify-content-around">
    <a href="{{route('identify.notvalid', $identify->id)}}" class="btn btn-danger btn-sm fs-3 p-2">Not Valid</a>
    <a href="{{route('identify.valid', $identify->id)}}" class="btn btn-success btn-sm fs-3 p-2">Valid</a>
  </div>
  @elseif($identify->status === 'not valid')
  <h3 style="color: rgba(160, 27, 37, 1);"><span class="text-black">status:</span> {{$identify->status}}</h3>
  @elseif($identify->status === 'valid')
  <h3 style="color: rgba(53, 169, 58, 1);"><span class="text-black">status:</span> {{$identify->status}}</h3>
  @endif
</div>
@endsection