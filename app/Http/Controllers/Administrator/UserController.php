<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateRequest;
use App\Repositories\UserRepository;
use App\Services\ProvinceService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    protected $provinceService;

    protected $userRepository;

    public function __construct(UserService $userService, ProvinceService $provinceService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->provinceService = $provinceService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userService->paginate(); //Gọi func ở tầng Service, nơi xử lý logic

        $config = [
            'js' => [
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'Administrator/css/plugins/switchery/switchery.css'
            ]
        ];

        $config['seo'] = config('apps.user');

        $template = 'Administrator.user.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'users'
        ));
    }

    public function create()
    {
        $provinces = $this->provinceService->getProvince();

        $template = 'Administrator.user.store';

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

        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'provinces'
        ));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('user.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = $this->userRepository->findByID($id);

        $provinces = $this->provinceService->getProvince();

        $template = 'Administrator.user.store';

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

        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            'user'
        ));
    }

    public function update($id, UpdateRequest $request)
    {
        if ($this->userService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('user.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.index');
    }

    public function delete($id)
    {
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
        $config['seo'] = config('apps.user');
        $user = $this->userRepository->findByID($id);
        $template = 'Administrator.user.delete';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'user'
        ));
    }

    public function destroy($id)
    {
        if ($this->userService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('user.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('user.index');
    }
}
