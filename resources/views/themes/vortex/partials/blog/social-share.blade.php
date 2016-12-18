<div class="social-icon-links-container">
    <ul class="social-icon-links socicon-round">
        @foreach($socialShareButtons as $socialShareButton)
            <li>
                <a href="{{ $socialShareButton['url'] }}" title="{{ $socialShareButton['title'] }}" data-post-id="{{ $post->id }}" data-social-network="{{ $socialShareButton['socialNetwork'] }}" class="social-icon-link {{ $socialShareButton['socialNetwork'] }}" target="_blank">
                    <i class="fa {{ $socialShareButton['icon'] }}"></i>
                </a>
            </li>
        @endforeach
    </ul>
</div>