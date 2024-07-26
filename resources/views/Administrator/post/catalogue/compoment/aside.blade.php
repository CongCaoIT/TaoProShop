<div class="ibox">
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="" class="control-label text-left">Chọn danh mục<span class="text-danger">
                            (*)</span></label>
                    <span class="text-danger notice">* Chọn Root nếu không có danh mục</span>
                    <select name="parentid" id="" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>Chọn ảnh đại diện</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row-img">
                    <span>
                        <img class="image img-cover img-target" src="{{ old('image') ?? 'Administrator/img/noimage.jpg' }}" alt="">
                        <input type="hidden" name="image" value="{{ old('image', $postCatalogue->image ?? '') }}">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>Cấu hình nâng cao</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="mb15">
                        <select name="publish" id="" class="form-control setupSelect2">
                            @foreach (config('apps.general.publish') as $key => $val)
                                <option value="{{ $key }}"
                                    {{ $key == old('publish', isset($postCatalogue->publish) ? $postCatalogue->publish : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="follow" id="" class="form-control setupSelect2">
                            @foreach (config('apps.general.follow') as $key => $val)
                                <option value="{{ $key }}"
                                    {{ $key == old('follow', isset($postCatalogue->follow) ? $postCatalogue->follow : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
