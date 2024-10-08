<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px" class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Ảnh</th>
            <th class="text-center">Họ tên</th>
            <th class="text-center">Email</th>
            <th class="text-center">Số điện thoại</th>
            <th class="text-center">Địa chỉ</th>
            <th class="text-center">Nhóm thành viên</th>
            <th style="width: 100px" class="text-center">Tình trạng</th>
            <th style="width: 100px" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($users) && is_object($users))
            @foreach ($users as $user)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $user->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        <span class="image image-cover"><img src="{{ $user->image }}" alt="Không có ảnh"></span>
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->address }}
                    </td>
                    <td>
                        {{ $user->user_catalogues->name }}
                    </td>
                    <td class="text-center js-switch-{{ $user->id }}">
                        <input type="checkbox" value="{{ $user->publish }}" class="js-switch status" data-field="publish"
                            data-model = "{{ $config['model'] }}" data-modelid = "{{ $user->id }}" {{ $user->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
