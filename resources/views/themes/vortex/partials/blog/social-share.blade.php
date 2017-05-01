@if(!empty($socialShareButton))
    <div class="social-icon-links-container">
        <ul class="social-icon-links socicon-round">
            @foreach($socialShareButtons as $socialShareButton)
                <li>
                    <?php $onlyVisibleMobile = !$socialShareButton['visibleDesktop'] && $socialShareButton['visibleMobile']; ?>
                    <a href="{{ $socialShareButton['url'] }}" title="{{ $socialShareButton['title'] }}"
                    data-postid="{{ $post->id }}" data-socialnetwork="{{ $socialShareButton['socialNetwork'] }}"
                    class="social-icon-link {{ $socialShareButton['socialNetwork'] }} {{ $onlyVisibleMobile ? 'visible-xs' : '' }}" target="_blank">
                        <i class="fa {{ $socialShareButton['icon'] }}"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif