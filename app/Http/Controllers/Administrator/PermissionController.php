<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionRepository;

    public function __construct(PermissionService $permissionService, PermissionRepository $permissionRepository)
    {
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'permission.index');

        $permissions = $this->permissionService->paginate($request);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'permission'
        ];

        $config['seo'] = __('messages.permission');

        $template = 'Administrator.permission.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'permissions'
        ));
    }

    public function create()
    {
        Gate::authorize('modules', 'permission.create');

        $template = 'Administrator.permission.store';
        $config = $this->configData();
        $config['seo'] = __('messages.permission');
        $config['method'] = 'create';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StorePermissionRequest $request)
    {
        if ($this->permissionService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('permission.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('permission.index');
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'permission.update');

        $permission = $this->permissionRepository->findByID($id);
        $template = 'Administrator.permission.store';
        $config = $this->configData();
        $config['seo'] = __('messages.permission');
        $config['method'] = 'edit';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'permission'
        ));
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        if ($this->permissionService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('permission.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('permission.index');
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'permission.destroy');

        $config['seo'] = __('messages.permission');
        $permission = $this->permissionRepository->findByID($id);
        $template = 'Administrator.permission.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'permission'
        ));
    }

    public function destroy($id)
    {
        if ($this->permissionService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('permission.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('permission.index');
    }

    private function configData()
    {
        return [
            'js' => [
                'Administrator/plugin/ckfinder_2/ckfinder.js',
                'Administrator/plugin/ckeditor/ckeditor.js',
                'Administrator/library/finder.js'
            ],
            'css' => []
        ];
    }
}
