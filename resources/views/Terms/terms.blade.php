@extends ('layout')
@section('content')
<h1>Terms</h1>
<div class="container">
  @if(count($terms) == 0)
  <h1>There are no Terms</h1>
  @else
  <div class="d-flex gap-5 mt-5 flex-wrap justify-content-center">
    @foreach($terms as $term)
    <div class="card" style="width: 18rem;">
      <div class="card-body d-flex flex-column justify-content-between">
        <h5 class="card-title mb-4">{{$term->title}}</h5>
        <p class="card-text ">{{$term->description}}.</p>
        <div class=" d-flex gap-2 justify-content-around">
          <form action="{{route('term.delete',$term->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm mt-3">Delete</button>
          </form>
          <div>
            <a href="{{route('term.show',$term->id)}}" class="btn btn-primary btn-sm mt-3">Edit</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>
@endsection