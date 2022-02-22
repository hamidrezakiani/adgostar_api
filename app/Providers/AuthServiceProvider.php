<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Representation;
use App\Models\RepresentationItemPeriod;
use App\Models\RepresentationTicket;
use App\Models\User;
use App\Models\UserTicket;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('user-ticket', function ($user,$id) {
            $userTicket = UserTicket::find($id);
            return
            ($userTicket && $userTicket->user_id == auth('user')->id())||
            ($userTicket && $userTicket->user->representation_id == auth('representation')->id());
        });

        Gate::define('representation-ticket', function ($user,$id) {
            $representationTicket = RepresentationTicket::find($id);
            return
            ($representationTicket && $representationTicket->representation_id == auth('representation')->id())||
            ($representationTicket && $representationTicket->representation->parent_id == auth('representation')->id());
        });

        Gate::define('representation-period', function ($user, $id) {
            $representationPeriod = RepresentationItemPeriod::find($id);
            return $representationPeriod && $representationPeriod->representation_id == auth('representation')->id();
        });
    }
}
