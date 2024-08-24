@include('Administrator.dashboard.component.breadcrumb', ['title' => $config['seo']['delete']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('attribute.catalogue.destroy', $attributeCatalogue->id) }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">{{ __('messages.general_information') }}</div>
                    <div class="panel-description">- {{ __('messages.delete_post_group') }} <span
                            style="color: red">{{ $attributeCatalogue->name }}</span>
                    </div>
                    <div class="panel-description">- {{ __('messages.note_irreversible') }}</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label">{{ __('messages.group_name') }} <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{ old('name', $attributeCatalogue->name ?? '') }}"
                                        class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mb15">
                <button class="btn btn-danger" type="submit" value="send" name="send">{{ __('messages.delete_data') }}</button>
            </div>
        </div>
    </div>
</form>
