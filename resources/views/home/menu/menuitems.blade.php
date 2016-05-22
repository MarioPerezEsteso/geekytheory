    <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
        <?php $itemCount = 1; ?>
        @foreach($menu as $menuItem)
            <li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"
                id="menuItem_{{ $itemCount }}">
                <div class="menuDiv">
			   <span title="Click to show/hide children" class="disclose">
                   <i class="glyphicon glyphicon-minus"></i>
			   </span>
			   <span title="Click to show/hide item editor" data-id="{{ $itemCount }}" class="expandEditor">
                   <i class="glyphicon glyphicon-triangle-bottom"></i>
			   </span>
                    <span data-id="{{ $itemCount }}" class="itemTitle">{{ $menuItem['text'] }}</span>
			   <span title="Click to delete item." data-id="{{ $itemCount }}"
                     class="deleteMenu glyphicon glyphicon-remove">
			   </span>
                    <div id="menuEdit{{ $itemCount }}" class="menuEdit hidden">
                        <div class="row menuEditForm">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <input class="form-control" name="text" type="text" value="{{ $menuItem['text'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input class="form-control" name="link" type="text" value="{{ $menuItem['link'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($menuItem['submenu'] !== null)
                    <?php $submenuItemCount = 1; ?>
                    @foreach($menuItem['submenu'] as $submenuItem)
                        <?php $submenuIndex = $itemCount . '-' . $submenuItemCount; ?>
                        <ol>
                            <li style="display: list-item;"
                                class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"
                                id="menuItem_{{ $submenuIndex }}">
                                <div class="menuDiv">
                           <span title="Click to show/hide children" class="disclose glyphicon glyphicon-minus">
                           </span>
                           <span title="Click to show/hide item editor" data-id="{{ $submenuIndex }}"
                                 class="expandEditor glyphicon glyphicon-triangle-bottom">
                           </span>
                           <span>
                           <span data-id="{{ $submenuIndex }}" class="itemTitle">{{ $submenuItem['text'] }}</span>
                           <span title="Click to delete item." data-id="{{ $submenuIndex }}"
                                 class="deleteMenu glyphicon glyphicon-remove">
                           </span>
                           </span>
                                    <div id="menuEdit{{ $submenuIndex }}" class="menuEdit hidden">
                                        <div class="row menuEditForm">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="text">Text</label>
                                                    <input class="form-control" name="text" type="text"
                                                           value="{{ $submenuItem['text'] }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="link">Link</label>
                                                    <input class="form-control" name="link" type="text"
                                                           value="{{ $submenuItem['link'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>
                        <?php $submenuItemCount++; ?>
                    @endforeach
                @endif
            </li>
            <?php $itemCount++; ?>
        @endforeach
    </ol>
    <input type="submit" class="btn btn-default" name="saveMenu" id="saveMenu" value="{{ trans('home.save') }}">
