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
