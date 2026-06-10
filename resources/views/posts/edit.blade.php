@extends('layouts.main')

@push('styles')
    @vite('resources/css/post/Edit.css')
@endpush

@section('content')
    <div class="edit-post-container">

        <h2 class="edit-post-title">
            ✏️ Խմբագրել Հայտարարությունը
        </h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Վերնագիր</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Կատեգորիա</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Գին (֏)</label>
                <input type="number" name="price" value="{{ old('price', $post->price) }}" class="form-input" required>
            </div>

            <div class="form-group last">
                <label class="form-label">Նկարագրություն</label>
                <textarea name="description" rows="6" class="form-textarea" required>{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="btn-group">
                <a href="{{ route('profile.index') }}" class="btn-cancel">
                    Չեղարկել
                </a>
                <button type="submit" class="btn-submit">
                    💾 Պահպանել Թարմացումները
                </button>
            </div>
        </form>
    </div>
@endsection
