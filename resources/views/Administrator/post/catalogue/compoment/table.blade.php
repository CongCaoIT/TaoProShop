<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên nhóm thành viên</th>
            <th class="text-center">Số thành viên</th>
            <th class="text-center">Ghi chú</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($postCatalogues) && is_object($postCatalogues))
            @foreach ($postCatalogues as $postCatalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $postCatalogue->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        {{ $postCatalogue->name }}
                    </td>
                    <td class="text-center">
                        {{ $postCatalogue->posts_count }}
                    </td>
                    <td>
                        {{ $postCatalogue->description }}
                    </td>
                    <td class="text-center js-switch-{{ $postCatalogue->id }}">
                        <input type="checkbox" value="{{ $postCatalogue->publish }}" class="js-switch status" data-field="publish"
                            data-model = "postCatalogue" data-modelid = "{{ $postCatalogue->id }}"
                            {{ $postCatalogue->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.catalogue.edit', $postCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('post.catalogue.delete', $postCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $postCatalogues->links('pagination::bootstrap-4') }}
</div>
