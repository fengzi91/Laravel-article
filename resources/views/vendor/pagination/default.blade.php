@if ($paginator->hasPages())
    <ul class="pagination mdui-btn-group">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><a href="javascript:void(0);" class="mdui-btn mdui-btn-dense" disabled>&laquo;</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="mdui-btn mdui-btn-dense" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><a href="javascript:void(0);" class="mdui-btn mdui-btn-dense" disabled>{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="javascript:void(0);" class="mdui-btn mdui-btn-dense mdui-btn-active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="mdui-btn mdui-btn-dense">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="mdui-btn mdui-btn-dense" rel="next">&raquo;</a></li>
        @else
            <li><a href="javascript:void(0);" class="mdui-btn mdui-btn-dense" disabled>&raquo;</a></li>
        @endif
    </ul>
@endif
