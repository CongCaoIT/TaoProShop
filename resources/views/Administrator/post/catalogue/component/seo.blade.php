<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.seo_configuration') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
            <div class="seo-container">
                <div class="seo-container">
                    <div class="seo-container">
                        <div class="h3 meta_title">
                            {{ old('meta_title', $postCatalogue->meta_title ?? '') ? old('meta_title', $postCatalogue->meta_title ?? '') : __('messages.no_seo_title') }}
                        </div>
                        <div class="canonical">
                            {{ old('canonical', $postCatalogue->canonical ?? '') ? old('canonical', $postCatalogue->canonical ?? '') : __('messages.url_placeholder') }}
                        </div>
                        <div class="meta_description">
                            {{ old('meta_description', $postCatalogue->meta_description ?? '') ? old('meta_description', $postCatalogue->meta_description ?? '') : __('messages.no_seo_description') }}
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
                                <span>{{ __('messages.seo_title') }}</span>
                                <span class="count_meta-title"></span>
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
                            <div class="flex-container">{{ __('messages.seo_keywords') }}</div>
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
                                <span>{{ __('messages.seo_description') }}</span>
                                <span class="count_meta-title">{{ __('messages.zero_characters') }}</span>
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
                                {{ __('messages.url') }} <span class="text-danger"> (*)</span>
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
