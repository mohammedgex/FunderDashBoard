@extends ('layout')
@section('content')
<h1>update Terms</h1>
<div class="container">
  <form action="{{route('term.update',$term->id)}}" method="POST" class="mt-5">
    @csrf
    @if(session('error'))
    <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mb-3">
      {{session('error')}}
    </div>
    @endif
    <div class="mb-3">
      <input type="text" name="title" value="{{$term->title}}" class="form-control" placeholder="Tiltle" aria-describedby="emailHelp">
      @error('title')
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{$message}}
      </div>
      @enderror
    </div>

    <div class="form-floating">
      <textarea class="form-control" placeholder="Leave a Description here" name="description" id="floatingTextarea2" style="height: 100px">{{$term->description}}</textarea>
      <label for="floatingTextarea2">Description</label>
      @error('description')
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{$message}}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary mt-3">Update</button>
  </form>
</div>
@endsection