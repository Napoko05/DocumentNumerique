@extends('layouts.journlist_app')

@section('page-title', 'Liste des utilisateurs')

@section('content')

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="font-heading font-bold text-base text-ink">Liste des utilisateurs</h2>
    </div>

    @if($users->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <p class="text-sm text-ink-muted">Aucun utilisateur trouvé.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-surface-muted border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">#</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Nom</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Email</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Rôles</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-surface-muted transition-colors">
                            <td class="px-6 py-4 text-ink-muted">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-medium text-ink">{{ $user->name }}</td>
                            <td class="px-4 py-4 text-ink-soft">{{ $user->email }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-700">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection
