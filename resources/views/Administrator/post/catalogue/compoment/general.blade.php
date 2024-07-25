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
            <textarea type="text" name="description" id="description" value="{{ old('description', $postCatalogue->description ?? '') }}"
                class="form-control ckeditor" placeholder="" autocomplete="off" data-height="150"></textarea>
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Nội dung</label>
            <textarea type="text" name="content" id="content" data-height="500" value="{{ old('content', $postCatalogue->content ?? '') }}"
                class="form-control ckeditor" placeholder="" autocomplete="off"></textarea>
        </div>
    </div>
</div>
