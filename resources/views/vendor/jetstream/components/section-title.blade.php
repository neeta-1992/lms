<div class="px-4 px-sm-0">
    <div class="d-flex justify-content-between">
        <div class="{{ !empty($badge) ? 'd-flex align-items-center' : '' }}" style="margin-bottom: 1.333rem;">
            <h4 class="mb-0 mr-2">{{ $title }}</h4>
            @if(!empty($badge))
                <span class="badge  badge-shortcode">{{ $badge }}</span>
            @endif
            @if(!empty($description))
            <p class="mt-1 text-muted">
                {{ $description }}
            </p>
            @endif
        </div>
        @isset($aside)
        <div>
            {{ $aside ?? '' }}
        </div>
        @endisset

    </div>
</div>
