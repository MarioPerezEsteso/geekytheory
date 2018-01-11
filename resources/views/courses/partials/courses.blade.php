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
                            @if ($course->isPublished())
                                <a href="{{ route('course', ['slug' => $course->slug]) }}">
                            @endif
                            <div class="cardheader" style="background: url('{{ $course->image }}');">
                                @if ($course->isFree())
                                    <div class="cardheader-label-free">Gratis</div>
                                @endif
                            </div>
                            @if ($course->isPublished())
                                </a>
                            @endif
                            <div class="avatar">
                                <img alt="{{ $course->teacher->name }}"
                                     src="{{ getGravatar($course->teacher->email, 50) }}">
                            </div>
                            <div class="info">
                                <div class="title">
                                    @if ($course->isPublished())
                                        <a href="{{ route('course', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                    @else
                                        {{ $course->title }}
                                    @endif
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="info">
                                            @if ($course->isPublished())
                                                <strong>¡Ya está disponible!</strong>
                                            @else
                                                <strong>Próximamente</strong>
                                            @endif
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