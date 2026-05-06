@extends('layouts.layout')

@section('main')
    <div class="form-container">
        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="edit-post-form">
            @csrf
            @method('patch')

            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}">
            </div>

            <div>
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
                @if($post->image)
                    <div class="current-image">
                        <p>Ընթացիկ նկարը:</p>
                        <img src="{{ asset('storage/' . $post->image) }}" width="100">
                    </div>
                @endif
            </div>

            <button type="submit">Update</button>
        </form>
    </div>

    @push('scripts')
        @vite(['resources/js/post-edit.js'])
    @endpush
@endsection
