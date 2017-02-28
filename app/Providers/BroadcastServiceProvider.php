<?php namespace Scalex\Zero\Providers;

use Broadcast;
use Illuminate\Support\ServiceProvider;
use Scalex\Zero\Http\Controllers\BroadcastController;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        Broadcast::channel($this->channel(User::class).'{userId}', function (User $user, $userId) {
            return $user->id === (int)$userId;
        });
        Broadcast::channel($this->channel(Group::class).'{groupId}', function (User $user, $groupId) {
            $group = Group::find($groupId);

            if ($group->isMember($user)) {
                return transform($user);
            }
        });
        Broadcast::channel($this->channel(School::class).'{schoolId}', function (User $user, $schoolId) {
            if ($user->school_id === (int)$schoolId) {
                return transform($user);
            }
        });
    }

    protected function channel($class): string
    {
        return morph_model($class).'-';
    }

    protected function registerRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        $attributes = [];

        $this->app['router']->group($attributes, function ($router) {
            $router->post('/broadcasting/auth', BroadcastController::class.'@authenticate');
        });
    }
}
