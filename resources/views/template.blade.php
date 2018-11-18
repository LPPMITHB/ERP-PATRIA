@extends('layouts.main')

@push('style')

@endpush

@section('content-header')
@breadcrumb(
    [
        'title' => 'Menus',
        'subtitle' => 'Index',
        'items' => [
            'Home' => route('index'),
            'Menus' => route('menus.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

@endsection

@push('script')

@endpush