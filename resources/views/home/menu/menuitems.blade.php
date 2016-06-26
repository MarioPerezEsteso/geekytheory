<ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
    @foreach($menu as $menuItem)
        <li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
            @include('home.menu.menuitemsingle', array('$menuItem' => $menuItem))
            @if ($menuItem['submenu'] !== null)
                <ol>
                    @foreach($menuItem['submenu'] as $submenuItem)
                        <li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
                            @include('home.menu.menuitemsingle', array('menuItem' => $submenuItem))
                        </li>
                    @endforeach
                </ol>
            @endif
        </li>
    @endforeach
</ol>
<div class="row">
    <div class="col-md-12">
        <p id="save-errormessage-feedback" class="notice pull-right hidden">
            {{ trans('home.menu_not_updated_successfully') }}
        </p>
    </div>
</div>
<button class="btn btn-default pull-right" name="saveMenu" id="saveMenu">
    {{ trans('home.save') }}
    <i id="save-loading-feedback" class="fa fa-circle-o-notch fa-spin hidden"></i>
    <i id="save-success-feedback" class="glyphicon glyphicon-ok success hidden"></i>
    <i id="save-error-feedback" class="glyphicon glyphicon-remove notice hidden"></i>
</button>