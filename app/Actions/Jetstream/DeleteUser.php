<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * 指定されたユーザーを削除する．
     *
     * @link https://jetstream.laravel.com/2.x/features/profile-management.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
