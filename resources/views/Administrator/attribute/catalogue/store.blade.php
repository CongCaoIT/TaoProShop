@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'],
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

@php
    $url = $config['method'] == 'create' ? route('attribute.catalogue.store') : route('attribute.catalogue.update', $attributeCatalogue->id);
@endphp

<form action="{{ $url }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.general_information') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('Administrator.dashboard.component.content', ['model' => $attributeCatalogue ?? null])
                    </div>
                </div>
                @include('Administrator.dashboard.component.album')
                @include('Administrator.dashboard.component.seo', ['model' => $attributeCatalogue ?? null])
            </div>
            <div class="col-lg-3">
                @include('Administrator.attribute.catalogue.component.aside')
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" value="send" name="send">{{ __('messages.save') }}</button>
        </div>
    </div>
</form>
