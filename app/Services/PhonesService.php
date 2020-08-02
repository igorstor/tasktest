<?php

namespace App\Services;


use App\Repositories\Contracts\PhoneRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class PhonesService
 * @package App\Services
 */
class PhonesService
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * PhonesService constructor.
     * @param PhoneRepository $repository
     */
    public function __construct(PhoneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int|null $limit
     * @return mixed
     */
    public function getList(int $limit = null)
    {
        $id = auth()->id();
        $this->repository->where('user_id', $id);

        if ($limit) {
            return $this->repository->paginate($limit);
        }
        return $this->repository->all();

    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $phone = $this->repository->create($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $phone;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();
            $phone = $this->repository->update($data, $id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $phone;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->repository->delete($id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return true;
    }
}
