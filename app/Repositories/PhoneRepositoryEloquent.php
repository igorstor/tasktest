<?php

namespace App\Repositories;

use App\Models\Phone;
use App\Repositories\Contracts\PhoneRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;


/**
 * Class PhoneRepositoryEloquent
 * @package App\Repositories
 */
class PhoneRepositoryEloquent extends BaseRepository implements PhoneRepository
{
    /**
     * Specify model class name
     *
     * @return string
     */
    public function model()
    {
        return Phone::class;
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
