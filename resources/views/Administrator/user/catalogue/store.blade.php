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
    $url = $config['method'] == 'create' ? route('user.catalogue.store') : route('user.catalogue.update', $userCatalogue->id);
@endphp

<form action="{{ $url }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung của nhóm thành viên</div>
                    <div class="panel-description">- Nhập thông tin chung </div>
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
                                    <label for="" class="control-label">Tên nhóm<span class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{ old('name', $userCatalogue->name ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Ghi chú</span></label>
                                    <input type="text" name="description" value="{{ old('description', $userCatalogue->description ?? '') }}"
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
