@extends ('layout')
@section('content')
    <x-app-layout>



        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg my-3">
                    <form action="{{ route('user.image', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="fileToUpload">
                            <div class="profile-pic"
                                style="background-image: url({{ url('uploads/' . auth()->user()->image) }})">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Image</span>
                            </div>
                        </label>
                        <input class="d-none" type="File" name="image" id="fileToUpload">
                        @error('image')
                            <div
                                class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="submit" value="save" class="btn btn-primary d-block mx-auto mt-4">
                    </form>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
