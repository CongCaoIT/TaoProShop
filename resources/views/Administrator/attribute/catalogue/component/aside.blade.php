<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}<span class="text-danger">
                (*)</span></h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">* {{ __('messages.parent_notice') }}</span>
                    <select name="parentid" id="" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option value="{{ $key }}"
                                {{ $key == old('parentid', isset($attributeCatalogue->parentid) ? $attributeCatalogue->parentid : '') ? 'selected' : '' }}>
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
        <h5>{{ __('messages.avt') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row-img">
                    <span>
                        <img src="{{ old('image', $attributeCatalogue->image ?? '') ? old('image', $attributeCatalogue->image ?? '') : 'Administrator/img/noimage.jpg' }}"
                            class="image img-cover img-target" alt="">
                        <input type="hidden" name="image" value="{{ old('image', $attributeCatalogue->image ?? '') }}">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.advanced_configuration') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="mb15">
                        <select name="publish" id="" class="form-control setupSelect2">
                            @foreach (__('general.publish') as $key => $val)
                                <option value="{{ $key }}"
                                    {{ $key == old('publish', isset($attributeCatalogue->publish) ? $attributeCatalogue->publish : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="follow" id="" class="form-control setupSelect2">
                            @foreach (__('general.follow') as $key => $val)
                                <option value="{{ $key }}"
                                    {{ $key == old('follow', isset($attributeCatalogue->follow) ? $attributeCatalogue->follow : '') ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
