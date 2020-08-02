<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;


/**
 * Class UserRepositoryEloquent
 * @package App\Repositories
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
