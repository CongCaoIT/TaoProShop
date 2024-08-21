<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\TranslateRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Repositories\LanguageRepository;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('modules', 'language.index');

        $languages = $this->languageService->paginate($request); //Gọi func ở tầng Service, nơi xử lý logic
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'language'
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
        Gate::authorize('modules', 'language.create');

        $template = 'Administrator.language.store';
        $config = $this->configData();
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
        Gate::authorize('modules', 'language.update');

        $language = $this->languageRepository->findByID($id);
        $template = 'Administrator.language.store';
        $config = $this->configData();
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
        Gate::authorize('modules', 'language.destroy');

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

    public function switchLanguage($id)
    {
        $language = $this->languageRepository->findByID($id);
        if ($this->languageService->switch($id)) {
            session(['app_locale' => $language->canonical]);
            App::setLocale($language->canonical);
        }
        return back();
    }

    public function translate($id = 0, $languageId = 0, $model = '')
    {
        Gate::authorize('modules', 'language.translate');

        $repositoryInstance = $this->repositoryInstance($model);
        $languageInstance = $this->repositoryInstance('Language');
        $currentLanguage = $languageInstance->findByCondition([
            ['canonical', '=', session('app_locale')]
        ]);
        $methodName = 'get' . $model . 'ById';
        $object = $repositoryInstance->{$methodName}($id, $currentLanguage->id); //lấy data để bắt đầu dịch
        $objectTranslate = $repositoryInstance->{$methodName}($id, $languageId);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/plugin/ckfinder_2/ckfinder.js',
                'Administrator/plugin/ckeditor/ckeditor.js',
                'Administrator/library/finder.js',
                'Administrator/library/seo.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet'
            ]
        ];
        $option = [
            'id' => $id,
            'languageId' => $languageId,
            'model' => $model
        ];
        $config['seo'] = __('messages.language');
        $template = 'Administrator.language.translate';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'object',
            'objectTranslate',
            'option'
        ));
    }

    private function repositoryInstance($model)
    {
        $repositoryNamespace = '\App\Repositories\\' . ucfirst($model) . 'Repository';
        if (class_exists($repositoryNamespace)) {
            $repositoryInstance = app($repositoryNamespace);
        }
        return $repositoryInstance ?? null;
    }

    public function storeTranslate(TranslateRequest $request)
    {
        $option = $request->input('option');
        if ($this->languageService->saveTranslate($option, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->back();
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->back();
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
