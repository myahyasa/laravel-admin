<div class="btn-group dropdown column-selector float-right mr-2">
    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-table"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
        @foreach($columns as $key => $label)
        @php
        if (empty($visible)) {
            $checked = 'checked';
        } else {
            $checked = in_array($key, $visible) ? 'checked' : '';
        }
        @endphp

        <li class="dropdown-item icheck-@theme d-inline">
            <input id="@id" type="checkbox" class="column-select-item" value="{{ $key }}" {{ $checked }}/>&nbsp;&nbsp;&nbsp;
            <label for="@id">{{ $label }}</label>
        </li>
        @endforeach
        <div class="dropdown-divider"></div>
        <li class="dropdown-item text-right">
            <button class="btn btn-sm btn-default column-select-all">{{ __('admin.all') }}</button>&nbsp;&nbsp;
            <button class="btn btn-sm btn-@theme column-select-submit">{{ __('admin.submit') }}</button>
        </li>
    </ul>
</div>

<style>
.column-selector .dropdown-menu {
    padding: 10px;
    height: auto;
    max-height: 500px;
    overflow-x: hidden;
}

.column-selector .dropdown-menu ul {
    padding: 0;
}

.column-selector .dropdown-menu ul li {
    margin: 0;
}

.column-selector .dropdown-menu label {
    width: 100%;
    padding: 3px;
}
</style>

<script>
$('.column-select-submit').on('click', function () {

    var defaults = @json($defaults);
    var selected = [];

    $('.column-select-item:checked').each(function () {
        selected.push($(this).val());
    });

    if (selected.length == 0) {
        return;
    }

    var url = new URL(location);

    if (selected.sort().toString() == defaults.sort().toString()) {
        url.searchParams.delete('_columns_');
    } else {
        url.searchParams.set('_columns_', selected.join());
    }

    $.pjax({container:'#pjax-container', url: url.toString()});
});

$('.column-select-all').on('click', function () {
    $('.column-select-item').prop('checked', true);
    return false;
});
</script>