@extends('layouts.app')

@push('head')
<style>
    #input:empty:before {
        content: 'Enter your overlay content...';
        color: #cbd5e0;
    }
</style>
@endpush

@section('content')
    @livewire('stacks.edit')
@endsection
