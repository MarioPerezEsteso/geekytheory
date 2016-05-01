<div class="post-author">
    <h4 class="post-author-title font-alt">{{ trans('home.author') }}</h4>
    <hr class="divider m-b-30">
    <div class="author-bio">
        <div class="author-avatar">
            <img src="{{ \App\Http\Controllers\UserController::getGravatar($post->user->email) }}" alt="">
        </div>
        <div class="author-content">
            <h5 class="author-name font-alt">{{ $post->user->name }}</h5>
            <p>{{ $post->user->biography }}</p>
            <ul class="social-icon-links socicon-round">
                @foreach(\App\Http\Controllers\UserController::$socialNetworks as $socialNetwork)
                    @if(!empty($post->user->$socialNetwork))
                        <li>
                            <a href="{{ $post->user->$socialNetwork }}" target="_blank"><i class="fa fa-{{ $socialNetwork }}"></i></a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>