<div class="card card-fluid bg-dark text-white overflow--hidden z-depth-3-top border-0">
    <div class="card-img-bg"
         style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($article->image) }}');"></div>
    <span class="mask mask-dark--style-2"></span>
    <div class="card-body py-5">
        <span class="d-block meta-category mb-3">
            @foreach($article->categories as $category)
                <a href="{{ route('post-category', ['slug' => $category->slug]) }}"
                   class="text-md strong-600">{{ $category->category }}</a>
            @endforeach
        </span>
        <h3 class="heading heading-inverse heading-3 strong-500">
            <a href="{{ route('article', ['slug' => $article->slug]) }}">{{ $article->title }}</a>
        </h3>
        <div class="excerpt">
            <p class="mt-3 mb-0 text-lg line-height-1_8 c-gray-lighter">{{ $article->description }}</p>
        </div>
    </div>

    <div class="card-footer border-0 pt-2 pb-4">
        <div class="row">
            <div class="col">
                <div class="block-author">
                    <div class="author-image author-image-xs">
                        <img src="{{ getGravatar($article->user->email) }}">
                    </div>
                    <div class="author-info">
                        <div class="author-name">
                            <a href="#" class="text-md strong-600 c-gray-lighter">{{ $article->user->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col text-right">
                <ul class="inline-links inline-links--style-2">
                    <li>
                        <span class="c-gray-lighter"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>