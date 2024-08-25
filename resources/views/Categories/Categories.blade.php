@extends ('layout')
@section('content')
<h1>Categories</h1>
<div class="container d-flex gap-3 pt-5 flex-wrap">
  @foreach($categories as $category)
  <div class="border border-3 border-solid border-black rounded col-2 p-3" style="min-width: 200px;">
    <h2 class="text-center mb-0">{{$category->name}}</h2>

    <div class="d-flex gap-2 justify-content-around">
      <form action="{{route('categories.delete', $category->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mt-3">Delete</button>
      </form>
      <div>
        <a href='{{route("categories.formUpdate", $category->id)}}' class="btn btn-primary btn-sm mt-3">Edit</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection