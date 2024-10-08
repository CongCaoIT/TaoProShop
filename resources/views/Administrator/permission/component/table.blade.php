<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px" class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tiêu đề</th>
            <th class="text-center">Canonical</th>
            <th style="width: 100px" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($permissions) && is_object($permissions))
            @foreach ($permissions as $permission)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $permission->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        {{ $permission->name }}
                    </td>
                    <td>
                        {{ $permission->canonical }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $permissions->links('pagination::bootstrap-4') }}
</div>
