@extends ('layout')
@section('content')
<form action="{{ route('categories.update', $category->id) }}" method="Post">
  @csrf
  <div class="container">
    <h2 class="text-base font-semibold leading-7 text-gray-900">Update Category</h2>
    <div class="mt-5">
      <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Category Name</span>
        <input type="text" class="form-control" value="{{$category->name}}" name='name' placeholder="Category Name" aria-label="Username" aria-describedby="addon-wrapping">
      </div>
      @error('name')
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{$message}}
      </div>
      @enderror
      @if(session('error'))
      <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
        {{session('error')}}
      </div>
      @endif
      <button type="submit" class="btn btn-primary btn-sm mt-3">Update</button>
    </div>
</form>
@endsection