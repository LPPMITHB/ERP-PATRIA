@extends('layouts.main')

@push('style')

@endpush

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2><br>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Whoops! Error Page.</h3>
            <p>
                You Are Not Authorized to Perform This Action.
            </p>
        </div>
    </div>
@endsection
