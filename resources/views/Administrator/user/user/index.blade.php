@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['seo']['index']['title'],
])
<div class="row mb20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['tableHeading'] }}</h5>
                @include('Administrator.user.user.component.toolbox') {{-- toolbox --}}
            </div>
            <div class="ibox-content">
                @include('Administrator.user.user.component.filter') {{-- filter --}}
                @include('Administrator.user.user.component.table') {{-- table --}}
            </div>
        </div>
    </div>
</div>
