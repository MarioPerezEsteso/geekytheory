    <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
        @foreach($menu as $menuItem)
            @include('home.menu.menuitemsingle')
        @endforeach
    </ol>
    <div class="row">
        <div class="col-md-12">
            <p id="save-errormessage-feedback" class="notice pull-right hidden">
                The menu could not be saved
            </p>
        </div>
    </div>
    <button class="btn btn-default pull-right" name="saveMenu" id="saveMenu">
        {{ trans('home.save') }}
        <i id="save-loading-feedback" class="fa fa-circle-o-notch fa-spin hidden"></i>
        <i id="save-success-feedback" class="glyphicon glyphicon-ok success hidden"></i>
        <i id="save-error-feedback" class="glyphicon glyphicon-remove notice hidden"></i>
    </button>