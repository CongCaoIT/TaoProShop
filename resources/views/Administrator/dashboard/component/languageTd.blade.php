@foreach ($language_all as $language)
    @if ($locale == $language->canonical)
        @continue;
    @endif
    <td style="width: 100px" class="text-center">
        @php
            $translated = $model->languages->contains('id', $language->id);
        @endphp
        <a class="{{ $translated ? '' : 'text-danger' }}"
            href="{{ route('language.translate', ['id' => $model->id, 'languageId' => $language->id, 'model' => $modeling]) }}">{{ $translated ? 'Đã dịch' : 'Chưa dịch' }}</a>
    </td>
@endforeach
