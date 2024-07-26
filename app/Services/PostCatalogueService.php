<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\PostCatalogueRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $nestedsetbie;

    public function __construct(PostCatalogueRepository $postCatalogueRepository)
    {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedsetbie = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage()
        ]);
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;

        //Xử lý logic
        $postCatalogues = $this->postCatalogueRepository->pagination(
            $this->select(),
            $condition, //Keyword
            [
                [
                    'post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=', 'post_catalogues.id'
                ]
            ], //Join table
            $perpage, //Page
            ['path' => 'post/catalogue'], //Path UR
            [],
            [
                'post_catalogues.lft', 'ASC'
            ],
        );
        return $postCatalogues;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->create($payload);
            if ($postCatalogue->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;

                $language = $this->postCatalogueRepository->createLanguagePivot($postCatalogue, $payloadLanguage);
            }

            $this->nestedsetbie->Get('level ASC, order ASC');
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);

            $this->postCatalogueRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->postCatalogueRepository->delete($id);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);

            $this->postCatalogueRepository->update($post['modelId'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function updateStatusAll($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function select()
    {
        return [
            'post_catalogues.id',
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.level',
            'post_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'parentid',
            'publish',
            'follow',
            'image'
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }
}
