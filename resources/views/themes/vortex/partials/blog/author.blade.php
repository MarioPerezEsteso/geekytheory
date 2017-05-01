<div class="post-author">
    <h4 class="post-author-title font-alt">{{ trans('home.author') }}</h4>
    <hr class="divider m-b-30">
    <div class="author-bio">
        <div class="author-avatar">
            <img src="{{ getGravatar($authorUser->email) }}" alt="">
        </div>
        <div class="author-content">
            <h5 class="author-name font-alt">{{ $authorUser->name }}</h5>
            @if(!empty($authorUser->userMeta))
                <p>{{ $authorUser->userMeta->biography }}</p>
                <ul class="social-icon-links socicon-round">
                    @foreach(\App\UserMeta::$socialNetworks as $socialNetwork)
                        @if(!empty($authorUser->userMeta->$socialNetwork))
                            <li>
                                <?php $faIcon = $socialNetwork; ?>
                                @if($socialNetwork == 'googleplus')
                                    <?php $faIcon = 'google-plus'; ?>
                                @elseif($socialNetwork == 'stackoverflow')
                                    <?php $faIcon = 'stack-overflow'; ?>
                                @endif
                                <a href="{{ $authorUser->userMeta->$socialNetwork }}" target="_blank"><i
                                            class="fa fa-{{ $faIcon }}"></i></a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>