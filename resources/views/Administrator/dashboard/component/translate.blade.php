<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('messages.post_title') }}<span class="text-danger"> (*)</span></label>
            <input type="text" name="translate_name" id="name" value="{{ old('translate_name', $model->name ?? '') }}" class="form-control"
                placeholder="" autocomplete="off">
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('messages.short_description') }}</span></label>
            <textarea type="text" name="translate_description" id="description_translate" class="form-control ckeditor" placeholder="" autocomplete="off"
                data-height="150">{{ old('translate_description', $model->description ?? '') }}</textarea>
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-beetween">
                <label for="" class="control-label text-left" style="width: 90%">{{ __('messages.content') }}</label>
                <a href="" class="multipleUploadImageCkeditor" data-target="content">{{ __('messages.upload_image') }}</a>
            </div>
            <textarea type="text" name="translate_content" id="content_translate" data-height="500" class="form-control ckeditor" placeholder=""
                autocomplete="off">{{ old('translate_content', $model->content ?? '') }}</textarea>
        </div>
    </div>
</div>
