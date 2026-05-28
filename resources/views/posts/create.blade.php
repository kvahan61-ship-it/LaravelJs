@extends('layouts.main')
@push('styles')
    @vite(['resources/css/post/create.css'])
@endpush
@section('content')
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Ստեղծել նոր ապրանք</h2>
            </div>

            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="post-form">
                @csrf

                <div class="form-group">
                    <label for="title">Ապրանքի անվանում</label>
                    <input type="text" name="title" id="title" class="@error('title') error-border @enderror" value="{{ old('title') }}" placeholder="Օրինակ՝ iPhone 15 Pro">
                    @error('title')
                    <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Կատեգորիա</label>
                    <select name="category_id" id="category_id" class="@error('category_id') error-border @enderror">
                        <option value="" disabled selected>Ընտրեք կատեգորիան</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Գին (֏)</label>
                    <input type="number" name="price" id="price" step="0.01" class="@error('price') error-border @enderror" value="{{ old('price') }}" placeholder="Մուտքագրեք գինը">
                    @error('price')
                    <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Ապրանքի նկարագրություն</label>
                    <textarea name="description" id="description" rows="4" class="@error('description') error-border @enderror" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; resize: vertical;" placeholder="Մանրամասն պատմեք ապրանքի մասին...">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Ավելացնել նկարներ</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="images[]" id="images" multiple>
                        <div class="file-upload-design">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Ընտրեք նկարները</span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('home') }}" class="btn-cancel">Չեղարկել</a>
                    <button type="submit" class="btn-submit">Հրապարակել</button>
                </div>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
@push('scripts')
    @vite(['resources/js/post/post-create.js'])
@endpush
