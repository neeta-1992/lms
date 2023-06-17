@if ($paginator->hasPages())
    <nav class="inmail_pagination">
		<p class="text-sm text-gray-700 inmail_pagination_left">
			{!! __('Showing') !!}
			@if ($paginator->firstItem())
			<span class="font-medium">{{ $paginator->firstItem() }}</span>
			{!! __('to') !!}
			<span class="font-medium">{{ $paginator->lastItem() }}</span>
			@else
			{{ $paginator->count() }}
			@endif
			{!! __('of') !!}
			<span class="font-medium">{{ $paginator->total() }}</span>
			{!! __('results') !!}
		</p>
        <ul class="pagination">           
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" rel="prev" aria-label="@lang('pagination.previous')" x-on:click="pagination('{{  $paginator->currentPage() - 1 }}')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" x-on:click="pagination('{{  $page }}')">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" rel="next" aria-label="@lang('pagination.next')" x-on:click="pagination('{{  $paginator->currentPage() + 1 }}')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
