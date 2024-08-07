<?php

namespace App\Http\Controllers\Administrator;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Services\BaseService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $nestedsetbie;
    protected $language;

    public function __construct(PostService $postService, PostRepository $postRepository)
    {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->nestedsetbie = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        $posts = $this->postService->paginate($request); //Gọi func ở tầng Service, nơi xử lý logic

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

        $config['seo'] = config('apps.post');

        $template = 'Administrator.post.post.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'posts'
        ));
    }

    public function create()
    {
        $template = 'Administrator.post.post.store';

        $config = $this->configData();
        $config['seo'] = config('apps.post');
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
        if ($this->postService->create($request)) {
            flash()->success('Thêm mới bản ghi thành công.');
            return redirect()->route('post.index');
        }
        flash()->error('Thêm mới bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        $post = $this->postRepository->getPostById($id, $this->language);

        $template = 'Administrator.post.post.store';
        $config = $this->configData();
        $dropdown = $this->nestedsetbie->Dropdown();
        $config['seo'] = config('apps.post');
        $config['method'] = 'edit';
        $album = json_decode($post->album);

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'post',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdatePostRequest $request)
    {
        if ($this->postService->update($id, $request)) {
            flash()->success('Sửa bản ghi thành công.');
            return redirect()->route('post.index');
        }
        flash()->error('Sửa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.index');
    }

    public function delete($id)
    {
        $post = $this->postRepository->getPostById($id, $this->language);
        $config['seo'] = config('apps.post');
        $template = 'Administrator.post.post.delete';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'post'
        ));
    }

    public function destroy($id)
    {
        if ($this->postService->destroy($id)) {
            flash()->success('Xóa bản ghi thành công.');
            return redirect()->route('post.index');
        }
        flash()->error('Xóa bản ghi không thành công. Hãy thử lại.');
        return redirect()->route('post.index');
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
