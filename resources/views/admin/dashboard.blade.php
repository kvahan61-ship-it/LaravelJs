@extends('layouts.main')

@section('content')
    <div class="admin-container" style="padding: 20px;">
        <h1>👑 Admin Panel</h1>
        <div class="stats-cards" style="display: flex; gap: 20px; margin-top: 20px;">
            <div class="card" style="background: #fff; padding: 20px; border: 1px solid #dbdbdb; border-radius: 8px; flex: 1;">
                <h3>Օգտատերեր</h3>
                <p style="font-size: 24px; font-weight: bold;">{{ $usersCount }}</p>
            </div>
            <div class="card" style="background: #fff; padding: 20px; border: 1px solid #dbdbdb; border-radius: 8px; flex: 1;">
                <h3>Պոստեր</h3>
                <p style="font-size: 24px; font-weight: bold;">{{ $postsCount }}</p>
            </div>
        </div>
    </div>
@endsection
