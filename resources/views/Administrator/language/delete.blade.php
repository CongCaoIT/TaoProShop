@include('Administrator.dashboard.component.breadcrumb', ['title' => $config['seo']['delete']['title']])

<form action="{{ route('language.destroy', $language->id) }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">- Bạn đang muốn xóa ngôn ngữ.
                    </div>
                    <div class="panel-description">- Lưu ý: Không thể khôi phục lại sau khi xóa.</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Tên ngôn ngữ<span class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{ old('name', $language->name ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Ghi chú</span></label>
                                    <input type="text" name="description" value="{{ old('description', $language->description ?? '') }}"
                                        class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mb15">
                <button class="btn btn-danger" type="submit" value="send" name="send">Xóa dữ liệu</button>
            </div>
        </div>
    </div>
</form>
