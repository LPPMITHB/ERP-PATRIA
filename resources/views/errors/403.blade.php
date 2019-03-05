@extends('layouts.main')

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2><br>
        <div class="error-content">
            <h3 class="headline"><i class="fa fa-warning text-yellow p-b-0 m-b-0"></i> Whoops! Error Page.</h3>
            <p>
                You Are Not Authorized to Perform This Action.
            </p><br>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();        
    });
</script>
@endpush