<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
        <h2>Cursos</h2>
        <br>
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-lg-4 col-sm-12">
                    <div class="card hovercard">
                        <div class="cardheader" style="background: url('{{ $course->image }}');"></div>
                        <div class="avatar">
                            <img alt="{{ $course->teacher->name }}" src="{{ getGravatar($course->teacher->email, 50) }}">
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
                                <div class="col-lg-8">
                                    @if ($course->free)
                                        <span class="pull-right subscription subscription-free">GRATIS</span>
                                    @else
                                        <span class="pull-right subscription subscription-pro">PREMIUM</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>