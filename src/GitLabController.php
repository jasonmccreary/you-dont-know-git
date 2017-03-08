<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Illuminate\Routing\Controller;

class GitLabController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('gitlab')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $gitlab_user = Socialite::driver('gitlab')->user();
        } catch (\Exception $e) {
            return Redirect::to('auth/gitlab');
        }

        $user = User::createOrUpdateGitLabUser($gitlab_user);

        Auth::login($user, true);

        return redirect('/account');
    }
}
