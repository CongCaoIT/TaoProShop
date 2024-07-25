@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'],
])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $url = $config['method'] == 'create' ? route('user.store') : route('user.update', $user->id);
@endphp

<form action="{{ $url }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">- Nhập thông tin chung người sử dụng</div>
                    <div class="panel-description">- Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span>
                        là bắt buộc</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Email<span class="text-danger">(*)</span></label>
                                    <input type="text" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Họ tên<span class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Nhóm thành viên<span class="text-danger">(*)</span></label>

                                    <select name="user_catalogue_id" id="" class="form-control mr10 setupSelect2">
                                        @foreach ($userCatalogues as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($user)) {{ old('user_catalogue_id', $user->user_catalogue_id) == $item->id ? 'selected' : '' }}
                                                @else
                                                    {{ old('user_catalogue_id') == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Ngày sinh</label>
                                    <input type="date" name="birthday"
                                        value="{{ old('birthday', isset($user->birthday) ? \Carbon\Carbon::parse($user->birthday)->format('Y-m-d') : '') }}"
                                        class="form-control" placeholder="" autocomplete="off">

                                </div>
                            </div>
                        </div>

                        @if ($config['method'] == 'create')
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label">Mật khẩu<span class="text-danger">(*)</span></label>
                                        <input type="password" name="password" value="" class="form-control" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label">Nhập lại mật khẩu<span
                                                class="text-danger">(*)</span></label>
                                        <input type="password" name="re_password" value="" class="form-control" placeholder=""
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label">Ảnh đại diện<span class="text-danger">(*)</span></label>
                                    <input type="text" name="image" value="{{ old('image', $user->image ?? '') }}"
                                        class="form-control input-image" placeholder="" autocomplete="off" data-type = "Images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin-top: 0; border-top: 1px solid #e4e1e1;">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Thành Phố/Tỉnh</label>
                                    <select name="province_id" id="" class="form-control setupSelect2 province location"
                                        data-target="districts">
                                        <option value="0">[Chọn Thành Phố/Tỉnh]</option>
                                        @if (isset($provinces))
                                            @foreach ($provinces as $province)
                                                <option @if (old('province_id') == $province->code) selected @endif value="{{ $province->code }}">
                                                    {{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Quận/Huyện</label>
                                    <select name="district_id" id="" class="form-control setupSelect2 districts location"
                                        data-target="wards">
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Phường/Xã</label>
                                    <select name="ward_id" id="" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Địa chỉ</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Số điện thoại</label>
                                    <input type="number" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Ghi chú</label>
                                    <input type="text" name="description" value="{{ old('description', $user->description ?? '') }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" value="send" name="send">Lưu lại</button>
        </div>
    </div>
</form>

<script>
    var province_id = '{{ isset($user->province_id) ? $user->province_id : old('province_id') }}'
    var district_id = '{{ isset($user->district_id) ? $user->district_id : old('district_id') }}'
    var ward_id = '{{ isset($user->ward_id) ? $user->ward_id : old('ward_id') }}'
</script>
