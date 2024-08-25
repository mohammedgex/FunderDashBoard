@extends ('layout')
@section('content')
<h1>Create Terms</h1>
<div class="container">
  <form action="{{route('term.add')}}" method="POST" class="mt-5">
    @csrf
    @if(session('error'))
    <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mb-3">
      {{session('error')}}
    </div>
    @endif
    <div class="mb-3">
      <input type="text" name="title" class="form-control" placeholder="Tiltle" aria-describedby="emailHelp">
      @error('title')
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{$message}}
      </div>
      @enderror
    </div>

    <div class="form-floating">
      <textarea class="form-control" placeholder="Leave a Description here" name="description" id="floatingTextarea2" style="height: 100px"></textarea>
      <label for="floatingTextarea2">Description</label>
      @error('description')
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{$message}}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary mt-3">Create</button>
  </form>
</div>
@endsection