@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['seo']['index']['title'],
])
<div class="row mb20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['tableHeading'] }}</h5>
                @include('Administrator.user.compoment.toolbox') {{-- toolbox --}}
            </div>
            <div class="ibox-content">
                @include('Administrator.user.compoment.filter') {{-- filter --}}
                @include('Administrator.user.compoment.table') {{-- table --}}
            </div>
        </div>
    </div>
</div>
