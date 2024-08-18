@include('Administrator.dashboard.component.breadcrumb', [
    'title' => $config['seo']['title'],
])

<form action="{{ route('user.catalogue.updatePermission') }}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cấp Quyền</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th class="text-center">Quyền</th>
                                @foreach ($userCatalogues as $userCatalogue)
                                    <th class="text-center" style="width: 150px;">
                                        {{ $userCatalogue->name }}
                                    </th>
                                @endforeach
                            </tr>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td style="font-size: 15px">
                                        <div style="color: #1a0dab" class="uk-flex uk-flex-middle uk-flex-space-between">{{ $permission->name }}
                                            <span style="color: rgb(245, 50, 50); font-size: 14px">({{ $permission->canonical }})</span>
                                        </div>
                                    </td>
                                    @foreach ($userCatalogues as $userCatalogue)
                                        <td>
                                            <input {{ collect($userCatalogue->permissions)->contains('id', $permission->id) ? 'checked' : '' }}
                                                type="checkbox" value="{{ $permission->id }}" name="permission[{{ $userCatalogue->id }}][]"
                                                class="form-control" style="height: 20px">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" value="send" name="send">Lưu lại</button>
        </div>
    </div>
</form>
