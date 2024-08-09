<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateRequest;
use App\Repositories\UserCatalogueRepository;
use App\Repositories\UserRepository;
use App\Services\ProvinceService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $provinceService;
    protected $userRepository;
    protected $userCatalogueRepository;

    public function __construct(UserService $userService, ProvinceService $provinceService, UserRepository $userRepository, UserCatalogueRepository $userCatalogueRepository)
    {
        $this->userService = $userService;
        $this->provinceService = $provinceService;
        $this->userRepository = $userRepository;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userService->paginate($request); //Gọi func ở tầng Service, nơi xử lý logic

        $userCatalogues = $this->userCatalogueRepository->all();

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'User'
        ];

        $config['seo'] = config('apps.user');

        $template = 'Administrator.user.user.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'users',
            'userCatalogues'
        ));
    }

    public function create()
    {
        $provinces = $this->provinceService->getProvince();

        $template = 'Administrator.user.user.store';

        $userCatalogues = $this->userCatalogueRepository->all();

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
            'provinces',
            'userCatalogues'
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

        $userCatalogues = $this->userCatalogueRepository->all();

        $template = 'Administrator.user.user.store';

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
            'user',
            'userCatalogues'
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
        $template = 'Administrator.user.user.delete';
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
