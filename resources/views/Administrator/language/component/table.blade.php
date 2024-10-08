<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px" class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center" style="width: 150px">Ảnh</th>
            <th class="text-center">Tên ngôn ngữ</th>
            <th class="text-center">Từ khóa</th>
            <th class="text-center">Mô tả</th>
            <th style="width: 100px" class="text-center">Trạng thái</th>
            <th style="width: 100px" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($languages) && is_object($languages))
            @foreach ($languages as $language)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $language->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        <span class="image image-cover"><img src="{{ $language->image }}" alt="Không có ảnh"></span>
                    </td>
                    <td>
                        {{ $language->name }}
                    </td>
                    <td class="text-center">
                        {{ $language->canonical }}
                    </td>
                    <td>
                        {{ $language->description }}
                    </td>
                    <td class="text-center js-switch-{{ $language->id }}">
                        <input type="checkbox" value="{{ $language->publish }}" class="js-switch status" data-field="publish"
                            data-model = "{{ $config['model'] }}" data-modelid = "{{ $language->id }}"
                            {{ $language->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('language.edit', $language->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('language.delete', $language->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $languages->links('pagination::bootstrap-4') }}
</div>
