<?php

namespace App\Http\Controllers\Administrator;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Repositories\PostCatalogueRepository;
use App\Services\PostCatalogueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedsetbie;
    protected $language;

    public function __construct(PostCatalogueService $postCatalogueService, PostCatalogueRepository $postCatalogueRepository)
    {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedsetbie = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'post.catalogue.index');
        
        $postCatalogues = $this->postCatalogueService->paginate($request); 
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet',
                'Administrator/css/plugins/switchery/switchery.css'
            ],
            'model' => 'postCatalogue'
        ];

        $config['seo'] = __('messages.postCatalogue');
        $template = 'Administrator.post.catalogue.index';
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogues'
        ));
    }

    public function create()
    {
        Gate::authorize('modules', 'post.catalogue.create');

        $template = 'Administrator.post.catalogue.store';
        $config = $this->configData();
        $config['seo'] = __('messages.postCatalogue');
        $config['method'] = 'create';
        $dropdown = $this->nestedsetbie->Dropdown();
        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('post.catalogue.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.catalogue.index');
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'post.catalogue.update');

        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        $template = 'Administrator.post.catalogue.store';
        $config = $this->configData();
        $dropdown = $this->nestedsetbie->Dropdown();
        $config['seo'] = __('messages.postCatalogue');
        $config['method'] = 'edit';
        $album = json_decode($postCatalogue->album);

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogue',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdatePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('post.catalogue.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.catalogue.index');
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'post.catalogue.destroy');
        
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        $config['seo'] = __('messages.postCatalogue');
        $template = 'Administrator.post.catalogue.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogue'
        ));
    }

    public function destroy($id, DeletePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('post.catalogue.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.catalogue.index');
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
