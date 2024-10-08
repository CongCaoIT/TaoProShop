<form action="{{ route('attribute.index') }}" method="GET">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                @php
                    $perpage = request('perpage') ?: old('perpage');
                @endphp
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" id="" class="form-control input-sm perpage filter mr10 setupSelect2">
                        @for ($i = 20; $i <= 200; $i += 20)
                            <option {{ $perpage == $i ? 'selected' : '' }} value="{{ $i }}">
                                {{ $i }} bản ghi
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    @php
                        $publish = request('publish') ?? old('publish', -1);
                        $attributeCatalogueId = request('attribute_catalogue_id') ?? old('attribute_catalogue_id', -1);
                    @endphp
                    <select name="publish" id="" class="form-control setupSelect2 ml10 mr10">
                        @foreach (config('apps.general.publish') as $key => $val)
                            <option {{ $publish == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    <select name="attribute_catalogue_id" id="" class="form-control setupSelect2 ml10 mr10">
                        @foreach ($dropdown as $key => $val)
                            <option {{ $attributeCatalogueId == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    <div class="uk-search uk-flex uk-middle mr10">
                        <div class="input-group" style="width: 300px">
                            <input type="text" name="keyword" value="{{ request('keyword') ?: old('keyword') }}"
                                placeholder="Nhập từ khóa bạn muốn tìm ..." class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('attribute.create') }}" class="btn btn-danger"><i class="fa fa-plus mr5"></i>Thêm</a>
                </div>
            </div>
        </div>
    </div>
</form>
