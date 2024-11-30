<?php
namespace App\Observers;

use App\Models\User;
use App\Models\Log;

class UserObserver
{
    public function created(User $user)
    {
        Log::create([
            'model' => User::class,
            'model_id' => $user->id,
            'action' => 'create',
            'changes' => $user->toArray(),
        ]);
    }

    public function updated(User $user)
    {
        $changes = $user->getChanges();
        Log::create([
            'model' => User::class,
            'model_id' => $user->id,
            'action' => 'update',
            'changes' => $changes,
        ]);
    }

    public function deleted(User $user)
    {
        Log::create([
            'model' => User::class,
            'model_id' => $user->id,
            'action' => 'delete',
            'changes' => null,
        ]);
    }
}
