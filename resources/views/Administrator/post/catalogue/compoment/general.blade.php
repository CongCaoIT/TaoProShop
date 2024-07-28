<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Tiêu đề bài viết<span class="text-danger"> (*)</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $postCatalogue->name ?? '') }}" class="form-control" placeholder=""
                autocomplete="off">
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Mô tả ngắn</span></label>
            <textarea type="text" name="description" id="description" class="form-control ckeditor" placeholder="" autocomplete="off" data-height="150">{{ old('description', $postCatalogue->description ?? '') }}</textarea>
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-beetween">
                <label for="" class="control-label text-left" style="width: 94%">Nội dung</label>
                <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">Upload ảnh</a>
            </div>
            <textarea type="text" name="content" id="content" data-height="500" class="form-control ckeditor" placeholder="" autocomplete="off">{{ old('content', $postCatalogue->content ?? '') }}</textarea>
        </div>
    </div>
</div>
