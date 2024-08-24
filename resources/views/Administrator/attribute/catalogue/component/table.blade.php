<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="width: 50px">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.group_name') }}</th>
            @include('Administrator.dashboard.component.languageTh')
            <th class="text-center" style="width: 100px">{{ __('messages.status') }}</th>
            <th class="text-center" style="width: 100px">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($attributeCatalogues) && is_object($attributeCatalogues))
            @foreach ($attributeCatalogues as $attributeCatalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $attributeCatalogue->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        {{ str_repeat('|---- ', $attributeCatalogue->level > 0 ? $attributeCatalogue->level - 1 : 0) . $attributeCatalogue->name }}
                    </td>
                    @include('Administrator.dashboard.component.languageTd', [
                        'model' => $attributeCatalogue,
                        'modeling' => 'AttributeCatalogue',
                    ])
                    <td class="text-center js-switch-{{ $attributeCatalogue->id }}">
                        <input type="checkbox" value="{{ $attributeCatalogue->publish }}" class="js-switch status" data-field="publish"
                            data-model = "{{ $config['model'] }}" data-modelid = "{{ $attributeCatalogue->id }}"
                            {{ $attributeCatalogue->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('attribute.catalogue.edit', $attributeCatalogue->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('attribute.catalogue.delete', $attributeCatalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $attributeCatalogues->links('pagination::bootstrap-4') }}
</div>
