@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['seo']['translate']['title'],
])

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('language.storeTranslate') }}" method="POST">
    @csrf
    <input type="hidden" name="option[id]" value="{{ $option['id'] }}">
    <input type="hidden" name="option[languageId]" value="{{ $option['languageId'] }}">
    <input type="hidden" name="option[model]" value="{{ $option['model'] }}">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.general_information') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('Administrator.dashboard.component.content', ['model' => $object ?? null, 'disabled' => 1])
                    </div>
                </div>
                @include('Administrator.dashboard.component.seo', ['model' => $object ?? null, 'disabled' => 1])
            </div>
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.general_information') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('Administrator.dashboard.component.translate', ['model' => $objectTranslate ?? null])
                    </div>
                </div>
                @include('Administrator.dashboard.component.seoTranslate', ['model' => $objectTranslate ?? null])
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" value="send" name="send">{{ __('messages.save') }}</button>
        </div>
    </div>
</form>
