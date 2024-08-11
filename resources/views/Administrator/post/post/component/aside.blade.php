<div class="ibox">
    <div class="ibox-title">
        <h5>Chọn danh mục<span class="text-danger">
                (*)</span></h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">* Chọn Root nếu không có danh mục</span>
                    <select name="post_catalogue_id" id="" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option value="{{ $key }}"
                                {{ $key == old('post_catalogue_id', isset($post->post_catalogue_id) ? $post->post_catalogue_id : '') ? 'selected' : '' }}>
                                {{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @php
            $catalogue = [];
            if (isset($post)) {
                foreach ($post->post_catalogues as $key => $value) {
                    $catalogue[] = $value->id;
                }
            }
        @endphp

        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">Danh mục phụ</label>
                    <select multiple name="catalogue[]" id="" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option @if (is_array(old('catalogue', isset($catalogue) && count($catalogue) ? $catalogue : [])) &&
                                    isset($post->post_catalogue_id) &&
                                    $key !== $post->post_catalogue_id &&
                                    in_array($key, old('catalogue', isset($catalogue) && count($catalogue) ? $catalogue : []))) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
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
                        <img src="{{ old('image', $post->image ?? '') ? old('image', $post->image ?? '') : 'Administrator/img/noimage.jpg' }}"
                            class="image img-cover img-target" alt="">
                        <input type="hidden" name="image" value="{{ old('image', $post->image ?? '') }}">
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
                                    {{ $key == old('publish', isset($post->publish) ? $post->publish : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="follow" id="" class="form-control setupSelect2">
                            @foreach (config('apps.general.follow') as $key => $val)
                                <option value="{{ $key }}"
                                    {{ $key == old('follow', isset($post->follow) ? $post->follow : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
