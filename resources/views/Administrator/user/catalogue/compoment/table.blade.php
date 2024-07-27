<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px" class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên nhóm thành viên</th>
            <th class="text-center">Số thành viên</th>
            <th class="text-center">Ghi chú</th>
            <th style="width: 100px" class="text-center">Trạng thái</th>
            <th style="width: 100px" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($userCatalogues) && is_object($userCatalogues))
            @foreach ($userCatalogues as $userCatalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $userCatalogue->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        {{ $userCatalogue->name }}
                    </td>
                    <td class="text-center">
                        {{ $userCatalogue->users_count }} người
                    </td>
                    <td>
                        {{ $userCatalogue->description }}
                    </td>
                    <td class="text-center js-switch-{{ $userCatalogue->id }}">
                        <input type="checkbox" value="{{ $userCatalogue->publish }}" class="js-switch status" data-field="publish"
                            data-model = "userCatalogue" data-modelid = "{{ $userCatalogue->id }}"
                            {{ $userCatalogue->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('user.catalogue.edit', $userCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('user.catalogue.delete', $userCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $userCatalogues->links('pagination::bootstrap-4') }}
</div>
