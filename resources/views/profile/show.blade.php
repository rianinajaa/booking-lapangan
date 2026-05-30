@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="font-headline-lg text-headline-lg text-on-surface mb-lg">Profil Saya</h1>
    
    <div class="glass-card rounded-xl p-lg">
        <div class="flex items-center gap-md pb-lg mb-lg border-b border-outline-variant/30">
            <div class="w-24 h-24 bg-surface-container-high rounded-full flex items-center justify-center">
                <iconify-icon icon="lucide:user" class="text-6xl text-primary"></iconify-icon>
            </div>
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">{{ $user->name }}</h2>
                <p class="text-on-surface-variant">{{ $user->email }}</p>
                <div class="mt-xs">
                    <span class="inline-block px-sm py-xs bg-primary/10 rounded-full text-primary text-xs font-label-bold">
                        {{ ucfirst($user->role ?? 'User') }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div>
                <label class="block text-on-surface-variant text-sm mb-xs">Nama Lengkap</label>
                <p class="text-on-surface bg-surface-container-high rounded-lg p-sm">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-on-surface-variant text-sm mb-xs">Email</label>
                <p class="text-on-surface bg-surface-container-high rounded-lg p-sm">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-on-surface-variant text-sm mb-xs">Role</label>
                <p class="text-on-surface bg-surface-container-high rounded-lg p-sm">{{ ucfirst($user->role ?? 'User') }}</p>
            </div>
            <div>
                <label class="block text-on-surface-variant text-sm mb-xs">Member Sejak</label>
                <p class="text-on-surface bg-surface-container-high rounded-lg p-sm">{{ $user->created_at->format('d F Y') }}</p>
            </div>
        </div>
        
        <div class="mt-lg pt-lg border-t border-outline-variant/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-error/20 text-error font-label-bold text-label-bold px-xl py-md rounded-full hover:bg-error/30 transition-all">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection