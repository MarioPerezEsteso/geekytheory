@if (!empty($post))
    {!! Form::model($post, ['url' => 'home/pages/update/' . $post->id, 'files' => true, 'class' => 'form']) !!}
@else
    {!! Form::open(['url' => 'home/pages/store', 'files' => true, 'class' => 'form']) !!}
@endif

@include('home.posts.partials.formFields')

{!! Form::close() !!}