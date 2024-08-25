@extends ('layout')
@section('content')
<h1>Users</h1>
<div class="container">
  @foreach ($users as $user)
  <div class="card mb-3 w-100">
    <div class="row g-0">
      <div class="col-md-4 border-end border-black">
        <img src="{{url('uploads/'. $user->image)}}" class="img-fluid rounded-start" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">{{$user->name}}</h5>
          <p class="card-text">{{$user->email}}</p>
          <p class="card-text"><small class="text-body-secondary">{{$user->created_at->formatLocalized('%d %B %Y')}}</small></p>
          <a href="{{route('user.show', $user->id)}}" class="btn btn-primary">read more</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection