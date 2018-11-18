@extends('layouts.main')

@push('style')

@endpush

@section('content-header')
@breadcrumb(
    [
        'title' => 'Configuration',
        'items' => [
            'Dashboard' => route('index'),
            'Configuration' => route('appearance.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <!-- <div class="box-title">
                    Default Skin
                </div> -->
            </div>
            <div class="box-body">
                <form action="{{ route('appearance.save') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="skin" class="col-sm-2 control-label">Choose Skin</label>
                        <div class="col-sm-10">
                            @foreach($defaultSkin->skins as $skin)
                                <div class="radio">
                                    <label>
                                    <input class="minimal" type="radio" name="default-skin" value="{{ $skin }}" {{ $skin == $defaultSkin->default ? 'checked' : '' }}>
                                        {{ $skin }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    //iCheck for checkbox and radio inputs
    $('input[type="radio"].minimal').iCheck({
      radioClass   : 'iradio_minimal-blue'
    })
</script>
@endpush