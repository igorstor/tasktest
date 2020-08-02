<?php

namespace App\Repositories;


use App\Models\VerifyUser;
use App\Repositories\Contracts\VerifyUserRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class VerifyUserRepositoryEloquent
 * @package App\Repositories
 */
class VerifyUserRepositoryEloquent extends BaseRepository implements VerifyUserRepository
{
    /**
     * Specify model class name
     *
     * @return string
     */
    public function model()
    {
        return VerifyUser::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @throws \Kobe\Foundation\Repository\Exceptions\RepositoryException
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param string $token
     * @return |null
     */
    public function checkToken(string $token)
    {
        $row = $this->model->where('token', $token)->first();
        if ($row) {
            return $row;
        }
    }
}
