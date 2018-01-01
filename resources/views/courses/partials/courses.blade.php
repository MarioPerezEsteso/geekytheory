<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
        <h2>Cursos</h2>
        <br>
        <?php $chunks = $courses->chunk(3); ?>
        @foreach  ($chunks as $coursesChunk)
            <div class="row">
                @foreach ($coursesChunk as $course)
                    <div class="col-lg-4 col-sm-12">
                        <div class="card hovercard">
                            <div class="cardheader" style="background: url('{{ $course->image }}');">
                                @if ($course->free)
                                    <div class="cardheader-label-free">Gratis</div>
                                @endif
                            </div>
                            <div class="avatar">
                                <img alt="{{ $course->teacher->name }}"
                                     src="{{ getGravatar($course->teacher->email, 50) }}">
                            </div>
                            <div class="info">
                                <div class="title">
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="info">
                                            {{--<span class="fui-user info"></span>{{ $course->students }}--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>