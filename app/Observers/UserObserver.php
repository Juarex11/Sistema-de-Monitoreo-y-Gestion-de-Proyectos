<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

   public function deleting(User $user)
{
    // Buscar administrador principal
    $admin = \App\Models\User::where('rol', 'administrador')->first();

    if (!$admin) {
        return; // si no hay admin, no hacer nada
    }

    // Reasignar proyectos
    \App\Models\Project::where('responsable_id', $user->id)
        ->update(['responsable_id' => $admin->id]);
}

    public function forceDeleted(User $user): void
    {
        //
    }
}
