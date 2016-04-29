<!-- POST -->
<div class="col-sm-6 col-md-4 col-lg-4 m-b-60">
    <div class="post">
        <div class="post-media">
            <a href="{{ url($post->slug) }}">
                <img src="{{'/' . \App\Http\Controllers\ImageManagerController::PATH_IMAGE_UPLOADS. '/' . $post->image }}" alt="">
            </a>
        </div>
        <div class="post-meta font-alt">
            {{ trans('public.by') }} <a href="{{ url('/user/' . $post->user->username) }}">{{ $post->name }}</a>
        </div>
        <div class="post-header">
            <h4 class="post-title font-alt">
                <a href="{{ url($post->slug) }}">{{ $post->title }}</a>
            </h4>
        </div>
        <div class="post-entry">
            <p>{{ $post->description }}</p>
        </div>
        <div class="post-more-link font-alt">
            <a href="{{ url($post->slug) }}">{{ trans('public.read_more') }}</a>
        </div>
    </div>
</div>
<!-- /POST -->