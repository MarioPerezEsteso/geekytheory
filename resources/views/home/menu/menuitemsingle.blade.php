<div class="box box-default collapsed-box">
    <div class="box-header with-border box-header-menu-item">
        <h3 class="box-title">{{ $menuItem['text'] }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-plus"></i>
            </button>
            <button name="remove-menu-item" type="button" class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body box-body-menu-item">
        <div class="col-md-12">
            <div class="form-group">
                <label for="text">{{ trans('home.text') }}</label>
                <input class="form-control" name="text" type="text"
                       value="{{ $menuItem['text'] }}">
            </div>
            <div class="form-group">
                <label for="link">{{ trans('home.link') }}</label>
                <input class="form-control" name="link" type="text"
                       value="{{ $menuItem['link'] }}">
            </div>
        </div>
    </div>
</div>
