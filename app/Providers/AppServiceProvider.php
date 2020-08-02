<?php

namespace App\Providers;

use App\Repositories\Contracts\PhoneRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VerifyUserRepository;
use App\Repositories\PhoneRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\VerifyUserRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    private $binds = [
        UserRepository::class => UserRepositoryEloquent::class,
        VerifyUserRepository::class => VerifyUserRepositoryEloquent::class,
        PhoneRepository::class => PhoneRepositoryEloquent::class,
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register contract implementation in container
        array_walk($this->binds, function ($implementation, $contract) {
            $this->app->bind($contract, $implementation);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_DEBUG')) {
            DB::listen(function($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            });
        }
    }
}
