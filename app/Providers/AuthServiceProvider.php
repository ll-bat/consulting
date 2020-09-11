<?php

namespace App\Providers;

use App\Blog;
use App\Comment;
use App\Export;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-best-comment', function (\App\User $user, Blog $blog){
            return $blog->user->is($user);
        });

        Gate::define('edit-staff', function (\App\User $user, Comment $comment){
            return $user->isAdmin() || $comment->user->is($user);
        });

        Gate::define('show-doc', function (\App\User $user, Export $export){
            return $export->user_id == $user->id;
        });

    }
}
