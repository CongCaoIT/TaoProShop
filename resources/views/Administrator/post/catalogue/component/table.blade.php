<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="width: 50px">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.group_name') }}</th>
            @foreach ($language_all as $language)
                @if (session('app_locale') == $language->canonical)
                    @continue;
                @endif
                <th style="width: 100px">
                    <span class="image img-scaledown" style="box-shadow: none; height: 30px;">
                        <img src="{{ $language->image }}" alt="">
                    </span>
                </th>
            @endforeach
            <th class="text-center" style="width: 100px">{{ __('messages.status') }}</th>
            <th class="text-center" style="width: 100px">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($postCatalogues) && is_object($postCatalogues))
            @foreach ($postCatalogues as $postCatalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $postCatalogue->id }}" class="input-checkbox checkboxItem">
                    </td>
                    <td>
                        {{ str_repeat('|---- ', $postCatalogue->level > 0 ? $postCatalogue->level - 1 : 0) . $postCatalogue->name }}
                    </td>
                    @foreach ($language_all as $language)
                        @if (session('app_locale') == $language->canonical)
                            @continue;
                        @endif
                        <td style="width: 100px" class="text-center">
                            <a
                                href="{{ route('language.translate', ['id' => $postCatalogue->id, 'languageId' => $language->id, 'model' => 'PostCatalogue']) }}">Chưa
                                dịch</a>
                        </td>
                    @endforeach
                    <td class="text-center js-switch-{{ $postCatalogue->id }}">
                        <input type="checkbox" value="{{ $postCatalogue->publish }}" class="js-switch status" data-field="publish"
                            data-model = "{{ $config['model'] }}" data-modelid = "{{ $postCatalogue->id }}"
                            {{ $postCatalogue->publish == 1 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.catalogue.edit', $postCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('post.catalogue.delete', $postCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-center">
    {{ $postCatalogues->links('pagination::bootstrap-4') }}
</div>
