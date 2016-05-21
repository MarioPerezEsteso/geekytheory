@if (!empty($post))
    {!! Form::model($post, ['url' => 'home/articles/update/' . $post->id, 'files' => true, 'class' => 'form']) !!}
@else
    {!! Form::open(['url' => 'home/articles/store', 'files' => true, 'class' => 'form']) !!}
@endif

@include('home.posts.partials.formFields')

{!! Form::close() !!}