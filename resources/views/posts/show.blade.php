@extends('layouts.layout')

@section('main')
    <div class="post-container">
        <div>
            <h1>{{$post->id}} . {{$post->title}}</h1>
        </div>

        <div class="actions">
            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">Update</a>

            <button type="button"
                    class="btn btn-danger delete-post-btn"
                    data-id="{{ $post->id }}"
                    data-url="{{ route('post.delete', $post->id) }}">
                Delete
            </button>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/post-delete.js'])
    @endpush
@endsection
