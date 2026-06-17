@extends('layouts.admin_app')

@section('page-title', 'Modifier le rôle')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <h2 class="font-heading font-bold text-lg text-ink mb-6">Modifier le rôle</h2>

        <form method="POST" action="{{ route('roles.update', $role->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Nom du rôle</label>
                <input type="text" name="name" value="{{ $role->name }}" required class="input-field">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-3">Permissions</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 hover:bg-surface-muted cursor-pointer transition-colors">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   class="w-4 h-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500"
                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <span class="text-sm text-ink">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-sm font-medium text-ink-soft hover:text-ink transition-colors">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
