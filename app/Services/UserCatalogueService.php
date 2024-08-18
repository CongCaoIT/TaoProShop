<?php

namespace App\Services;

use App\Repositories\UserCatalogueRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class UserCatalogueService
 * @package App\Services
 */
class UserCatalogueService implements UserCatalogueServiceInterface
{
    protected $userCatalogeRepository;

    public function __construct(UserCatalogueRepository $userCatalogeRepository)
    {
        $this->userCatalogeRepository = $userCatalogeRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $perpage = $request->input('perpage');
        //Xử lý logic
        $users = $this->userCatalogeRepository->pagination(
            ['id', 'name', 'description', 'publish'],
            $condition,
            $perpage,
            [],
            ['path' => 'user/catalogue'],
            [],
            ['users']
        );
        return $users;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);

            $this->userCatalogeRepository->create($payload);
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

            $this->userCatalogeRepository->update($id, $payload);
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
            $this->userCatalogeRepository->delete($id);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function setPermission($request)
    {
        DB::beginTransaction();
        try {
            $permissions = $request->input('permission');
            foreach ($permissions as $key => $val) {
                $userCatalogue = $this->userCatalogeRepository->findByID($key);
                $userCatalogue->permissions()->sync($val);
            }
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

            $this->userCatalogeRepository->update($post['modelId'], $payload);
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

            $this->userCatalogeRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }
}
