<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('postTitle')</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="themes/vortex/assets/images/favicon.png">
    <link rel="apple-touch-icon" href="themes/vortex/assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="themes/vortex/assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="themes/vortex/assets/images/apple-touch-icon-114x114.png">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Plugins -->
    <link href="themes/vortex/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/ionicons.min.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/simpletextrotator.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/magnific-popup.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/owl.carousel.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/superslides.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/vertical.css" rel="stylesheet">
    <link href="themes/vortex/assets/css/animate.css" rel="stylesheet">

    <!-- Template core CSS -->
    <link href="themes/vortex/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- PRELOADER -->
<div class="page-loader">
    <div class="loader">Loading...</div>
</div>
<!-- /PRELOADER -->

<!-- OVERLAY MENU -->
@include('themes.vortex.partials.overlay-menu')
<!-- /OVERLAY MENU -->

<!-- WRAPPER -->
<div class="wrapper">

    <!-- NAVIGATION -->
    @include('themes.vortex.partials.navigation')
    <!-- /NAVIGATION -->

    <!-- HERO -->
    <section class="module module-parallax bg-light-30" data-background="{{ \App\Http\Controllers\ImageManagerController::PATH_IMAGE_UPLOADS . '/' . $post->image }}">
        <!-- HERO TEXT -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1 class="mh-line-size-3 font-alt m-b-20">{{ $post->title }}</h1>
                    <h5 class="mh-line-size-4 font-alt">{{ $post->description }}</h5>
                </div>
            </div>
        </div>
        <!-- /HERO TEXT -->
    </section>
    <!-- /HERO -->

    <!-- SINGLE POST -->
    <section class="module">
        <div class="container">
            <div class="row">
                <!-- CONTENT -->
                <div class="col-sm-10 col-sm-offset-1">
                    <article class="post post-single">
                        <!-- META -->
                        <div class="post-meta font-alt">
                            Por <a href="blog-single.html#">{{ $post->user->name }}</a>
                        </div>
                        <!-- /META -->
                        <!-- HEADER -->
                        <div class="post-header">
                            <h1 class="post-title font-alt">
                                {{ $post->title }}
                            </h1>
                        </div>
                        <!-- /HEADER -->
                        <!-- POST CONTENT -->
                        <div class="post-entry">
                            {!! $post->body !!}
                        </div>
                        <!-- /POST CONTENT -->

                        <!-- TAGS -->
                        <div class="tags">
                            <a href="blog-single.html#">Art</a>
                            <a href="blog-single.html#">Design</a>
                            <a href="blog-single.html#">Pop Culture</a>
                        </div>
                        <!-- /TAGS -->

                    </article>

                    <!-- AUTHOR -->
                    <div class="post-author">
                        <h4 class="post-author-title font-alt">Author</h4>
                        <hr class="divider m-b-30">

                        <div class="author-bio">
                            <div class="author-avatar">
                                <img src="https://s3.amazonaws.com/uifaces/faces/twitter/draganbabic/128.jpg" alt="">
                            </div>
                            <div class="author-content">
                                <h5 class="author-name font-alt">Mark Stone</h5>
                                <p>It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.</p>
                                <ul class="social-icon-links socicon-round">
                                    <li><a href="blog-single.html#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="blog-single.html#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="blog-single.html#" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                                    <li><a href="blog-single.html#" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="blog-single.html#" target="_blank"><i class="fa fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /AUTHOR -->

                    <!-- COMMENTS -->
                    <div class="comments">
                        <h4 class="comment-title font-alt">3 comments</h4>
                        <hr class="divider m-b-30">

                        <!-- COMMENT 1 -->
                        <div class="comment clearfix">
                            <div class="comment-avatar">
                                <img src="https://s3.amazonaws.com/uifaces/faces/twitter/ryanbattles/128.jpg" alt="">
                            </div>
                            <div class="comment-content clearfix">
                                <h5 class="comment-author font-alt">
                                    <a href="blog-single.html#">John Doe</a>
                                </h5>
                                <div class="comment-body">
                                    <p>The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The European languages are members of the same family. Their separate existence is a myth.</p>
                                </div>
                                <div class="comment-meta font-alt">Today, 14:55 - <a href="blog-single.html#">Reply</a></div>
                            </div>

                            <!-- COMMENT 2 -->
                            <div class="comment clearfix">
                                <div class="comment-avatar">
                                    <img src="https://s3.amazonaws.com/uifaces/faces/twitter/draganbabic/128.jpg" alt="">
                                </div>
                                <div class="comment-content clearfix">
                                    <h5 class="comment-author font-alt">
                                        <a href="blog-single.html#">Mark Stone</a>
                                    </h5>
                                    <div class="comment-body">
                                        <p>The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The European languages are members of the same family. Their separate existence is a myth.</p>
                                    </div>
                                    <div class="comment-meta font-alt">Today, 14:55 - <a href="blog-single.html#">Reply</a></div>
                                </div>
                            </div>
                            <!-- /COMMENT 2 -->

                        </div>
                        <!-- /COMMENT 1 -->

                        <!-- COMMENT 3 -->
                        <div class="comment clearfix">
                            <div class="comment-avatar">
                                <img src="https://s3.amazonaws.com/uifaces/faces/twitter/pixeliris/128.jpg" alt="">
                            </div>
                            <div class="comment-content clearfix">
                                <h5 class="comment-author font-alt">
                                    <a href="blog-single.html#">Andy</a>
                                </h5>
                                <div class="comment-body">
                                    <p>The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The European languages are members of the same family. Their separate existence is a myth.</p>
                                </div>
                                <div class="comment-meta font-alt">Today, 14:55 - <a href="blog-single.html#">Reply</a></div>
                            </div>
                        </div>
                        <!-- COMMENT 3 -->

                    </div>
                    <!-- /COMMENTS -->

                    <!-- COMMENT FORM -->
                    <div class="comment-form">
                        <h4 class="comment-form-title font-alt">Leave a comment</h4>
                        <hr class="divider m-b-30">

                        <div class="row">

                            <form>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="name" type="text" class="form-control" placeholder="Name" name="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control" placeholder="E-mail" name="email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="website" type="text" class="form-control" placeholder="Website" name="website">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="message" name="message" class="form-control" placeholder="Message" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-round btn-g">Post Comment</button>
                                </div>
                            </form>

                        </div>

                    </div>
                    <!-- /COMMENT FORM -->

                </div>
                <!-- /CONTENT -->

            </div>

        </div>

    </section>
    <!-- /SINGLE POST -->

    <!-- FOOTER -->
    @include('themes.vortex.partials.footer')
    <!-- /FOOTER -->

</div>
<!-- /WRAPPER -->

<!-- SCROLLTOP -->
<div class="scroll-up">
    <a href="blog-single.html#totop"><i class="fa fa-angle-double-up"></i></a>
</div>

<!-- Javascript files -->
<script src="themes/vortex/assets/js/jquery-2.1.3.min.js"></script>
<script src="assets/js/bootstrap/bootstrap.min.js"></script>
<script src="themes/vortex/assets/js/jquery.superslides.min.js"></script>
<script src="themes/vortex/assets/js/jquery.mb.YTPlayer.min.js"></script>
<script src="themes/vortex/assets/js/jquery.magnific-popup.min.js"></script>
<script src="themes/vortex/assets/js/owl.carousel.min.js"></script>
<script src="themes/vortex/assets/js/jquery.simple-text-rotator.min.js"></script>
<script src="themes/vortex/assets/js/imagesloaded.pkgd.js"></script>
<script src="themes/vortex/assets/js/isotope.pkgd.min.js"></script>
<script src="themes/vortex/assets/js/packery-mode.pkgd.min.js"></script>
<script src="themes/vortex/assets/js/appear.js"></script>
<script src="themes/vortex/assets/js/jquery.easing.1.3.js"></script>
<script src="themes/vortex/assets/js/wow.min.js"></script>
<script src="themes/vortex/assets/js/jqBootstrapValidation.js"></script>
<script src="themes/vortex/assets/js/jquery.fitvids.js"></script>
<script src="themes/vortex/assets/js/jquery.parallax-1.1.3.js"></script>
<script src="themes/vortex/assets/js/smoothscroll.js"></script>
<script src="themes/vortex/assets/js/contact.js"></script>
<script src="themes/vortex/assets/js/custom.js"></script>
</body>
</html>