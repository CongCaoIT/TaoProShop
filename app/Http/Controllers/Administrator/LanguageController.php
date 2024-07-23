<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Repositories\LanguageRepository;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $languageService;
    protected $languageRepository;

    public function __construct(LanguageService $languageService, LanguageRepository $languageRepository)
    {
        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
    }

    public function index(Request $request)
    {
        $languages = $this->languageService->paginate($request); //Gọi func ở tầng Service, nơi xử lý logic

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ]
        ];

        $config['seo'] = config('apps.language');

        $template = 'Administrator.language.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'languages'
        ));
    }

    public function create()
    {
        $template = 'Administrator.language.store';

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

        $config['seo'] = config('apps.language');
        $config['method'] = 'create';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreLanguageRequest $request)
    {
        if ($this->languageService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('language.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('language.index');
    }

    public function edit($id)
    {
        $language = $this->languageRepository->findByID($id);

        $template = 'Administrator.language.store';

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

        $config['seo'] = config('apps.language');
        $config['method'] = 'edit';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'language'
        ));
    }

    public function update($id, UpdateLanguageRequest $request)
    {
        if ($this->languageService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('language.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('language.index');
    }

    public function delete($id)
    {
        $config['seo'] = config('apps.language');
        $language = $this->languageRepository->findByID($id);
        $template = 'Administrator.language.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'language'
        ));
    }

    public function destroy($id)
    {
        if ($this->languageService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('language.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('language.index');
    }
}
