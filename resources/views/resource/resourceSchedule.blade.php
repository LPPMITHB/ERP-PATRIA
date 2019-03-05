@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Resources Schedule',
        'items' => [
            'Dashboard' => route('index'),
            'esources Schedule' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush