<?php

namespace App\Http\Controllers\Administrator;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Language;
use App\Repositories\LanguageRepository;
use App\Repositories\AttributeRepository;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AttributeController extends Controller
{
    protected $attributeService;
    protected $attributeRepository;
    protected $nestedsetbie;
    protected $language;

    public function __construct(AttributeService $attributeService, AttributeRepository $attributeRepository)
    {
        $this->attributeService = $attributeService;
        $this->attributeRepository = $attributeRepository;
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
        Gate::authorize('modules', 'attribute.index');

        $languageId = $this->language;
        $attributes = $this->attributeService->paginate($request, $languageId); //Gọi func ở tầng Service, nơi xử lý logic
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'attribute'
        ];
        $config['seo'] = __('messages.attribute');
        $dropdown = $this->nestedsetbie->Dropdown();
        $template = 'Administrator.attribute.attribute.index';
        $locale = App::getLocale();
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attributes',
            'dropdown',
            'languageId',
            'locale'
        ));
    }

    public function create()
    {
        Gate::authorize('modules', 'attribute.create');

        $template = 'Administrator.attribute.attribute.store';
        $config = $this->configData();
        $config['seo'] = __('messages.attribute');
        $config['method'] = 'create';
        $dropdown = $this->nestedsetbie->Dropdown();
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function store(StoreAttributeRequest $request)
    {
        $languageId = $this->language;
        if ($this->attributeService->create($request, $languageId)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('attribute.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.index');
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'attribute.update');

        $attribute = $this->attributeRepository->getattributeById($id, $this->language);
        $template = 'Administrator.attribute.attribute.store';
        $config = $this->configData();
        $dropdown = $this->nestedsetbie->Dropdown();
        $config['seo'] = __('messages.attribute');
        $config['method'] = 'edit';
        if ($attribute && property_exists($attribute, 'album')) {
            $album = json_decode($attribute->album);
        } else {
            $album = null;
        }
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attribute',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdateAttributeRequest $request)
    {
        $languageId = $this->language;
        if ($this->attributeService->update($id, $request, $languageId)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('attribute.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.index');
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'attribute.destroy');

        $attribute = $this->attributeRepository->getattributeById($id, $this->language);
        $config['seo'] = __('messages.attribute');
        $template = 'Administrator.attribute.attribute.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'attribute'
        ));
    }

    public function destroy($id)
    {
        if ($this->attributeService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('attribute.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('attribute.index');
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
