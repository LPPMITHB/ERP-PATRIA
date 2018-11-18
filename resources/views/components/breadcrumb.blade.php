<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    @foreach($items as $name => $url)
        @if($loop->last)
            <li class="active">{{ $name }}</li>
        @else
            <li><a href="{{ $url }}">{{ $name }}</a></li>
        @endif
    @endforeach
</ol>