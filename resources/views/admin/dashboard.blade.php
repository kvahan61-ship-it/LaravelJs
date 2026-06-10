@extends('layouts.main')

@push('styles')
    @vite('resources/css/admin/admin.css')
@endpush

@section('content')
    <div class="admin-container">

        <div class="admin-header">
            <h1 class="admin-title">
                👑 Admin Panel
                <span class="role-badge-mode">
                    {{ ucfirst(auth()->user()->role) }} Mode
                </span>
            </h1>
        </div>

        <div class="stats-cards">
            <div class="stats-card">
                <h3>{{ in_array(auth()->user()->role, ['admin', 'superadmin']) ? "Ընդհանուր Օգտատերեր" : "Արգելափակված Փոստեր" }}</h3>
                <p class="stats-number">{{ in_array(auth()->user()->role, ['admin', 'superadmin']) ? $usersCount : $blockedPosts }}</p>
            </div>
            <div class="stats-card">
                <h3>Ակտիվ Պոստեր</h3>
                <p class="stats-number">{{ $publicPosts }}</p>
            </div>
        </div>

        @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
            <div class="admin-section">
                <h2 class="section-title">👥 Օգտատերերի Կառավարում</h2>
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Անուն</th>
                        <th>Email</th>
                        <th>Դեր</th>
                        <th style="text-align: center;">Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="{{ !$user->is_active ? 'tr-blocked' : 'tr-active' }}">
                            <td style="font-weight: bold;">#{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                    <span class="role-badge role-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>

                                @if(!$user->is_active)
                                    <span class="block-tag">🔒 Բլոկ</span>
                                @endif
                            </td>
                            <td class="actions-cell">
                                <form action="{{ route('admin.users.toggleActive', $user->id) }}" method="POST" class="btn-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->is_active)
                                        <button type="submit" class="btn-admin-action btn-block" onclick="return confirm('Վստա՞հ ես, որ ուզում ես արգելափակել այս օգտատիրոջը։')">
                                            🛑 Բլոկել
                                        </button>
                                    @else
                                        <button type="submit" class="btn-admin-action btn-unblock">
                                            🔓 Ակտիվացնել
                                        </button>
                                    @endif
                                </form>

                                @if(auth()->user()->role === 'superadmin')
                                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="btn-inline">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="role-select">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                        </select>
                                    </form>
                                @endif

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="btn-inline" onsubmit="return confirm('Վստա՞հ ես, որ ուզում ես ամբողջությամբ ջնջել այս օգտատիրոջը։')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="admin-section no-margin">
            <h2 class="section-title">📦 Պոստերի (Ապրանքների) Վերահսկողություն</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Վերնագիր</th>
                        <th>Տեղադրող</th>
                        <th>Կարգավիճակ</th>
                        <th style="text-align: center;">Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr class="{{ !$post->is_published ? 'tr-blocked' : 'tr-active' }}">
                            <td style="font-weight: bold;">#{{ $post->id }}</td>
                            <td>{{ Str::limit($post->title, 40) }}</td>
                            <td style="color: #555;">{{ $post->user->name ?? 'Անհայտ' }}</td>
                            <td>
                                @if($post->is_published)
                                    <span class="status-badge badge-active">Ակտիվ</span>
                                @else
                                    <span class="status-badge badge-blocked">Ապակտիվացված</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('admin.posts.toggleBlock', $post->id) }}" method="POST" class="btn-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($post->is_published)
                                        <button type="submit" class="btn-post-action btn-block" onclick="return confirm('Վստա՞հ ես, որ ուզում ես ապակտիվացնել այս պոստը։')">
                                            🛑 Ապակտիվացնել
                                        </button>
                                    @else
                                        <button type="submit" class="btn-post-action btn-unblock">
                                            🔓 Ակտիվացնել
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
