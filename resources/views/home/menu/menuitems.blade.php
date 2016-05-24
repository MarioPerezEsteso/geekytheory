    <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
        @foreach($menu as $menuItem)
            <li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border box-header-menu-item">
                        <h3 class="box-title">{{ $menuItem['text'] }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body box-body-menu-item">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="text">Text</label>
                                <input class="form-control" name="text" type="text"
                                       value="{{ $menuItem['text'] }}">
                            </div>
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input class="form-control" name="link" type="text"
                                       value="{{ $menuItem['link'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            </li>
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