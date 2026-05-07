@if ($paginator->hasPages())
    <nav class="custom-pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn disabled">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">‹</a>
        @endif

        {{-- Page Numbers --}}
        <div class="page-numbers">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">›</a>
        @else
            <span class="page-btn disabled">›</span>
        @endif
    </nav>
@endif
