<?php

namespace App\Http\Controllers\Administrator;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Language;
use App\Repositories\AttributeCatalogueRepository;
use App\Repositories\LanguageRepository;
use App\Services\AttributeCatalogueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AttributeCatalogueController extends Controller
{
    protected $attributeCatalogueService;
    protected $attributeCatalogueRepository;
    protected $nestedsetbie;
    protected $language;

    public function __construct(AttributeCatalogueService $attributeCatalogueService, AttributeCatalogueRepository $attributeCatalogueRepository)
    {
        $this->attributeCatalogueService = $attributeCatalogueService;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });
    }

    private function initialize()
    {
        $this->nestedsetbie = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'attribute.catalogue.index');

        $languageId = $this->language;
        $attributeCatalogues = $this->attributeCatalogueService->paginate($request, $languageId); //Gọi func ở tầng Service, nơi xử lý logic
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'AttributeCatalogue'
        ];
        $config['seo'] = __('messages.attributeCatalogue');
        $dropdown = $this->nestedsetbie->Dropdown();
        $template = 'Administrator.attribute.catalogue.index';
        $locale = App::getLocale();
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attributeCatalogues',
            'dropdown',
            'languageId',
            'locale'
        ));
    }

    public function create()
    {
        Gate::authorize('modules', 'attribute.catalogue.create');

        $template = 'Administrator.attribute.catalogue.store';
        $config = $this->configData();
        $config['seo'] = __('messages.attributeCatalogue');
        $config['method'] = 'create';
        $dropdown = $this->nestedsetbie->Dropdown();
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function store(StorePostRequest $request)
    {
        $languageId = $this->language;
        if ($this->attributeCatalogueService->create($request, $languageId)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('attribute.catalogue.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.catalogue.index');
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'attribute.catalogue.update');

        $attributeCatalogue = $this->attributeCatalogueRepository->getAttributeCatalogueById($id, $this->language);
        $template = 'Administrator.attribute.catalogue.store';
        $config = $this->configData();
        $dropdown = $this->nestedsetbie->Dropdown();
        $config['seo'] = __('messages.attributeCatalogue');
        $config['method'] = 'edit';
        if ($attributeCatalogue && property_exists($attributeCatalogue, 'album')) {
            $album = json_decode($attributeCatalogue->album);
        } else {
            $album = null;
        }

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attributeCatalogue',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdatePostRequest $request)
    {
        $languageId = $this->language;
        if ($this->attributeCatalogueService->update($id, $request, $languageId)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('attribute.catalogue.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.catalogue.index');
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'attribute.catalogue.destroy');

        $attributeCatalogue = $this->attributeCatalogueRepository->getAttributeCatalogueById($id, $this->language);
        $config['seo'] = __('messages.attributeCatalogue');
        $template = 'Administrator.attribute.catalogue.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attributeCatalogue'
        ));
    }

    public function destroy($id)
    {
        $languageId = $this->language;
        if ($this->attributeCatalogueService->destroy($id, $languageId)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('attribute.catalogue.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.catalogue.index');
    }

    private function configData()
    {
        return [
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
    }
}
