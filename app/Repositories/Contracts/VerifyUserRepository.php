<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VerifyUserRepository
 * @package App\Repositories\Contracts
 */
interface VerifyUserRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @param string $token
     * @return mixed
     */
    public function checkToken(string $token);
}
