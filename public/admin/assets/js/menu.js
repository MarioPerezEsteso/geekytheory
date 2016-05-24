var ns = $('ol.sortable').nestedSortable({
    forcePlaceholderSize: true,
    handle: 'div',
    helper: 'clone',
    items: 'li',
    opacity: .6,
    placeholder: 'placeholder',
    revert: 250,
    tabSize: 25,
    tolerance: 'pointer',
    toleranceElement: '> div',
    maxLevels: 1,
    isTree: true,
    expandOnHover: 700,
    startCollapsed: false,
    change: function () {
        console.log('Relocated item');
    }
});

$('.expandEditor').attr('title', 'Click to show/hide item editor');
$('.disclose').attr('title', 'Click to show/hide children');
$('.deleteMenu').attr('title', 'Click to delete item.');

$('.disclose').on('click', function () {
    $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
    $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
});

$('.expandEditor, .itemTitle').click(function () {
    var id = $(this).attr('data-id');
    $('#menuEdit' + id).toggleClass('hidden');
    $(this).toggleClass('glyphicon-triangle-bottom').toggleClass('glyphicon-triangle-top');
});

$('.deleteMenu').click(function () {
    var id = $(this).attr('data-id');
    $('#menuItem_' + id).remove();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#saveMenu').click(function () {
    var menuJson = [];
    $('#save-loading-feedback').removeClass('hidden');
    $('#save-success-feedback,#save-error-feedback,#save-errormessage-feedback').addClass('hidden');
    $('ol.sortable > li').each(function () {
        var current = $(this);
        var currentMenuJson = {};
        currentMenuJson['text'] = current.find('input[name=text]').val()
        currentMenuJson['link'] = current.find('input[name=link]').val();
        var submenuJson = {};
        current.find('ol > li').each(function () {
            submenuJson['text'] = $(this).find('input[name=text]').val();
            submenuJson['link'] = $(this).find('input[name=link]').val();
            submenuJson['submenu'] = null;
        });
        if (submenuJson.length == 0) {
            currentMenuJson['submenu'] = null;
        } else {
            currentMenuJson['submenu'] = submenuJson;
        }
        menuJson.push(currentMenuJson);
    });
    $.ajax({
        type: 'post',
        url: '/home/menu/update',
        data: {
            menu: JSON.stringify(menuJson)
        },
        dataType: 'json',
        success: function (response) {
            $('#save-loading-feedback').addClass('hidden');
            if (response.error == 0) {
                $('#save-success-feedback').removeClass('hidden');
            } else {
                $('#save-error-feedback').removeClass('hidden');
                $('#save-errormessage-feedback').removeClass('hidden');
            }
        },
        error: function (response) {
            $('#save-loading-feedback').addClass('hidden');
            $('#save-error-feedback').removeClass('hidden');
            $('#save-errormessage-feedback').removeClass('hidden');
        }
    });
});