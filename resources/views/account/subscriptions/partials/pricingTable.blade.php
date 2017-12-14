<div class="row price-table price-table--highlight">
    <div class="col-lg-6">
        <div class="price-table__item">
            <header class="price-table__header bg-teal">
                <div class="price-table__title">Plan Gratuito</div>
            </header>
            <div class="price-table__price color-teal">
                0 €/
                <small>mes</small>
            </div>
            <ul class="price-table__info">
                <li>In dapibus ipsum sit amet leo</li>
                <li>Vestibulum ut mauris tellus donec</li>
                <li>Purna lectus venenatis felis nonsemper</li>
                <li>Aliquam erat volutpat hasellus ultri</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="price-table__item price-table__item--popular">
            <header class="price-table__header bg-blue">
                <div class="price-table__title">Plan Premium</div>
            </header>
            <div class="price-table__price color-blue">
                {{ \App\Subscription::PLAN_MONTHLY_PRICE_EUR }} €/
                <small>mes</small>
            </div>
            <ul class="price-table__info">
                <li>Morbi leo risus porta acconseetur</li>
                <li>Nullam quis risus eget urna mollis ornare</li>
                <li>Purna lectus venenatis felis nonsemper</li>
                <li>Aenean ellentesque ornare sem lacinia</li>
            </ul>
        </div>
    </div>
</div>