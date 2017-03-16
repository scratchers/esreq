<ol class="breadcrumb">
    <li><a href="{{ route('report') }}">Reports</a></li>
    @unless ( empty($breadcrumbs) )
    @foreach ( $breadcrumbs as $breadcrumb )
        @unless ( empty($breadcrumb['link']) )
            <li><a href="{{ $breadcrumb['link'] }}?{{ $query or '' }}">{{ $breadcrumb['text'] }}</a></li>
        @else
            <li class="active">{{ $breadcrumb['text'] }}</li>
        @endunless
    @endforeach
    @endunless
</ol>
