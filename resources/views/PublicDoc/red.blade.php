@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">

    <div class="bg-white rounded-2xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            {{ $document->title }}
        </h1>

        <iframe
            src="{{ asset('storage/'.$document->file_path) }}"
            class="w-full h-[900px] border rounded-xl">
        </iframe>

    </div>

</div>

@endsection