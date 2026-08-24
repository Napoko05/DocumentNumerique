@extends('layouts.admin_app')

@section('page-title', 'Rôles')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="font-heading font-bold text-lg text-ink">Rôles</h2>
    <a href="{{ route('admin.roles.create') }}" class="btn-primary flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau rôle
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-surface-muted border-b border-slate-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">#</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Nom</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Permissions</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($roles as $role)
                    <tr class="hover:bg-surface-muted transition-colors">
                        <td class="px-6 py-4 text-ink-muted">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 font-medium text-ink">{{ $role->name }}</td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions as $perm)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-700">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                               class="inline-flex items-center px-3 py-1.5 rounded-lg border border-accent-300 text-accent-700 text-xs font-medium hover:bg-accent-50 transition-colors">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
