<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Http\Requests\UpdateUserCatalogueRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\UserCatalogueRepository;
use App\Services\UserCatalogueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;

    public function __construct(UserCatalogueService $userCatalogueService, UserCatalogueRepository $userCatalogueRepository, PermissionRepository $permissionRepository)
    {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'user.catalogue.index');

        $userCatalogues = $this->userCatalogueService->paginate($request);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'userCatalogue'
        ];

        $config['seo'] = config('apps.usercatalogue');

        $template = 'Administrator.user.catalogue.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues'
        ));
    }

    public function create()
    {
        Gate::authorize('modules', 'user.catalogue.create');

        $template = 'Administrator.user.catalogue.store';
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/library/location.js',
                'Administrator/plugin/ckfinder_2/ckfinder.js',
                'Administrator/library/finder.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet'
            ]
        ];

        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'create';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreUserCatalogueRequest $request)
    {
        if ($this->userCatalogueService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('user.catalogue.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.catalogue.index');
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'user.catalogue.update');

        $userCatalogue = $this->userCatalogueRepository->findByID($id);
        $template = 'Administrator.user.catalogue.store';
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/library/location.js',
                'Administrator/plugin/ckfinder_2/ckfinder.js',
                'Administrator/library/finder.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet'
            ]
        ];

        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'edit';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue'
        ));
    }

    public function update($id, UpdateUserCatalogueRequest $request)
    {
        if ($this->userCatalogueService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('user.catalogue.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.catalogue.index');
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'user.catalogue.destroy');

        $config['seo'] = config('apps.usercatalogue');
        $userCatalogue = $this->userCatalogueRepository->findByID($id);
        $template = 'Administrator.user.catalogue.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue'
        ));
    }

    public function destroy($id)
    {
        if ($this->userCatalogueService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('user.catalogue.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.catalogue.index');
    }

    public function permission()
    {
        Gate::authorize('modules', 'user.catalogue.permission');

        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $permissions = $this->permissionRepository->all();
        $config['seo'] = __('messages.userCatalogue.permission');
        $config['method'] = 'create';
        $template = 'Administrator.user.catalogue.permission';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues',
            'permissions'
        ));
    }

    public function updatePermission(Request $request)
    {
        if ($this->userCatalogueService->setPermission($request)) {
            flash()->success('Cập nhật quyền thành công.');
            return redirect()->route('user.catalogue.index');
        }
        flash()->error('Cập nhật quyền không thành công. Hãy thử lại.');
        return redirect()->route('user.catalogue.index');
    }
}
