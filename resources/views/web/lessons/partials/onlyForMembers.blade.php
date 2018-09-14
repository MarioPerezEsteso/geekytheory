<section class="slice-xs">
    <span class="mask mask-dark--style-1"></span>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white lesson-cta-card">
                    <img class="card-img lesson-cta-img" src="{{ $lesson->image }}" alt="Lección solo para miembros Premium">
                    <span class="mask mask-dark--style-2"></span>
                    <div class="card-img-overlay d-flex align-items-center text-center">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <h3 class="heading heading-inverse heading-2 strong-600">Esta lección es solo para miembros Premium</h2>
                                <p class="card-text c-gray-lighter">¡Suscríbete hoy y obtén acceso a todas las lecciones! ¡No te quedes atrás!</p>
                                <a href="{{ route('pricing') }}" class="btn btn-styled btn-base-1 btn-circle">Pásate a Premium</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>