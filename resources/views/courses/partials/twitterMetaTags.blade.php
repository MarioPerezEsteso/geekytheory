<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $course->title }}">
<meta name="twitter:description" content="{{ $course->description }}">
<meta name="twitter:image" content="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($course->image, false, true) }}">