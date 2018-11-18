@if(Session::has('error'))
        iziToast.error({
            title: '{{ session()->get('error') }}',
            position: 'topRight',
            displayMode: 'replace'
        });
@endif
@if(Session::has('success'))
        iziToast.success({
            title: '{{ session()->get('success') }}',
            position: 'topRight',
            displayMode: 'replace'
        });
@endif
@if(Session::has('warning'))
        iziToast.warning({
            title: '{{ session()->get('warning') }}',
            position: 'topRight',
            displayMode: 'replace'
        });
@endif
@if(Session::has('info'))
        iziToast.info({
            title: '{{ session()->get('info') }}',
            position: 'topRight',
            displayMode: 'replace'
        });
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        iziToast.error({
            timeout : false,
            progressBar: false,
            message: '{{ $error }}',
            position: 'topRight',
            messageColor : 'white',
            icon: 'fa fa-ban',
            iconColor : 'white',
            backgroundColor: '#b71c1c'
        });
    @endforeach
@endif