@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            @php
                $window = 2;
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();

                $start = max($currentPage - $window, 1);
                $end = min($currentPage + $window, $lastPage);
            @endphp

            {{-- First Page Link --}}
            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            {{-- Sliding Window Links --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page Link --}}
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif