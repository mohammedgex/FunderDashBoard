@extends ('layout')
@section('content')
    <h1>edit timeline : {{ $timeline->title }}<h1>
            <div class="container mt-5">
                <form action="{{ route('timeline.update', $timeline->id) }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                        <input type="date" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="date" value="{{ $timeline->date }}">
                    </div>
                    @error('date')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="title" value="{{ $timeline->title }}">
                    </div>
                    @error('title')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-group flex-nowrap my-3">
                        <span class="input-group-text" id="description">Description</span>
                        <textarea class="form-control" placeholder="Leave a Description here" required name="description" id="floatingTextarea2"
                            style="height: 100px">{{ $timeline->description }}</textarea>
                    </div>
                    @error('description')
                        <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 my-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        @endsection
