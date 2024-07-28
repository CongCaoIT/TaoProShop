<div class="ibox">
    <div class="ibox-title">
        <h5>Cấu hình SEO</h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
            <div class="seo-container">
                <div class="seo-container">
                    <div class="seo-container">
                        <div class="h3 meta_title">
                            {{ old('meta_title', $postCatalogue->meta_title ?? '') ? old('meta_title', $postCatalogue->meta_title ?? '') : 'Bạn chưa có tiêu đề SEO' }}
                        </div>
                        <div class="canonical">
                            {{ old('canonical', isset($postCatalogue) && $postCatalogue->canonical ? config('app.url') . $postCatalogue->canonical . config('apps.general.suffix') : 'https://duong-dan-cua-ban.html') }}
                        </div>
                        <div class="meta_description">
                            {{ old('meta_description', $postCatalogue->meta_description ?? '') ? old('meta_description', $postCatalogue->meta_description ?? '') : 'Bạn chưa có mô tả SEO' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="seo-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="flex-container">
                                <span>Tiêu đề SEO</span>
                                <span class="count_meta-title">0 ký tự</span>
                            </div>
                        </label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $postCatalogue->meta_title ?? '') }}" class="form-control"
                            placeholder="" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mt8">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="flex-container">
                                Từ khóa SEO
                            </div>
                        </label>
                        <input type="text" name="meta_keyword" value="{{ old('meta_keyword', $postCatalogue->meta_keyword ?? '') }}"
                            class="form-control" placeholder="" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mt8">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="flex-container">
                                <span>Mô tả SEO</span>
                                <span class="count_meta-title">0 ký tự</span>
                            </div>
                        </label>
                        <textarea type="text" name="meta_description" id="meta_description" class="form-control" placeholder="" autocomplete="off">{{ old('meta_description', $postCatalogue->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row mt8">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="">
                                Đường dẫn <span class="text-danger"> (*)</span>
                            </div>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="canonical" value="{{ old('canonical', $postCatalogue->canonical ?? '') }}"
                                class="form-control" placeholder="" autocomplete="off">
                            <span class="baseURL">{{ config('app.url') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
