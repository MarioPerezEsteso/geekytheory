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
                                    <div class="col-lg-12">
                                        <div class="info">
                                            ¡Ya está disponible!
                                            {{--<span class="fui-user info"></span>{{ $course->students }}--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-4 col-sm-12">
                    <div class="card hovercard">
                        <div class="cardheader"
                             style="background: url('https://geekytheory.com/uploads/2018/01/vuejs.jpeg');">
                        </div>
                        <div class="avatar">
                            <img alt="Mario Pérez Esteso"
                                 src="//www.gravatar.com/avatar/4a6f506a1fc112ebbbaa3f26b19f175a?s=50&amp;d=mm&amp;r=g">
                        </div>
                        <div class="info">
                            <div class="title">
                                Curso de Vue.JS
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="info">
                                        <span class="fui-calendar"></span> 1 de febrero de 2018
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>