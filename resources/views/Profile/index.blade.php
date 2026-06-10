@extends('layouts.main')

@push('styles')
    @vite('resources/css/Profile/Profile.css')
@endpush

@section('content')
    <div class="profile-container">

        <div class="profile-sidebar">

            <div class="avatar-wrapper">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                     alt="Avatar"
                     class="avatar-img">
            </div>

            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="avatar-form">
                @csrf
                <label models for="avatar-input" class="avatar-label">
                    <i class="fa fa-camera"></i> Փոխել նկարը
                </label>
                <input type="file" id="avatar-input" name="avatar" accept="image/*" onchange="this.form.submit()" style="display: none;">
            </form>

            <hr class="profile-hr">

            <form action="{{ route('profile.update') }}" method="POST" class="info-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Անուն</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-input">
                </div>

                <div class="form-group email-group">
                    <label class="form-label">Эլ. փոստ (Email)</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-input">
                </div>

                <button type="submit" class="btn-submit">
                    Պահպանել Փոփոխությունները
                </button>
            </form>
        </div>

        <div class="profile-content">
            <h2 class="content-title">
                📦 Իմ հայտարարությունները ({{ $myPosts->count() }})
            </h2>

            <div class="posts-grid">
                @forelse($myPosts as $post)
                    <div class="post-card">

                        <div class="post-image-wrapper">
                            @if($post->images->count() > 0)
                                <img src="{{ str_starts_with($post->images->first()->path, 'demo-') ? asset('images/products/' . str_replace('demo-', '', $post->images->first()->path)) : asset('storage/' . $post->images->first()->path) }}"
                                     class="post-img">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="post-img">
                            @endif

                            <span class="status-badge" style="background: {{ $post->is_published ? '#28a745' : '#dc3545' }};">
                                {{ $post->is_published ? 'Ակտիվ' : 'Պասիվ' }}
                            </span>
                        </div>

                        <div class="post-info">
                            <h4 class="post-title">{{ Str::limit($post->title, 35) }}</h4>
                            <div>
                                <div class="post-price">
                                    {{ number_format($post->price, 0, '.', ' ') }} ֏
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('post.show', $post->id) }}" class="btn-view">
                                        Դիտել
                                    </a>

                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn-edit">
                                        ✏️ Փոխել
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-message">
                        <p class="empty-text">Դուք դեռ ոչ մի հայտարարություն չեք տեղադրել։</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
