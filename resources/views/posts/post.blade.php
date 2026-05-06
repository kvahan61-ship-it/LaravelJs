<div class="post-card">
    <div class="post-header">
        <div class="avatar-small-container">
            @if($post->user && $post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="avatar" class="avatar-small-img">
            @else
                <div class="avatar-small-placeholder">
                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="username">User_{{ $post->user->id ?? $post->id }}</div>
    </div>

    <h3>{{$post->title}}</h3>

    <div class="post-photo">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="post-main-image" alt="post">
        @else
            <div style="height: 300px; background: #fafafa; display: flex; align-items: center; justify-content: center; color: #ccc;">
                No Image
            </div>
        @endif
    </div>

    <div class="post-actions">
        <div class="left-actions">
            <button class="action-btn like-btn" data-id="{{ $post->id }}" title="Like">
                @if(auth()->user()->likePosts->contains($post->id))
                    <i class="fa fa-heart" aria-hidden="true" style="color: #e00;"></i>
                @else
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                @endif
                <span class="likes-count">{{ $post->like_users_count ?? '' }}</span>
            </button>

            <button class="action-btn" title="Comment"><i class="fa fa-commenting" aria-hidden="true"></i></button>
        </div>

        <div class="right-actions">
            <button class="action-btn save-btn" data-id="{{ $post->id }}" title="Save">
                @if(auth()->user()->savedPosts->contains($post->id))
                    <i class="fa fa-bookmark" aria-hidden="true" style="color: #262626;"></i>
                @else
                    <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                @endif
            </button>
        </div>
    </div>
</div>
