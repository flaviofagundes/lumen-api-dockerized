<?php
//zach: classe que possui a definição de como ocorre a autenticação
namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

//use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            $token = null;

            if(!empty($request->header('Authorization'))){
                $token = $request->header('Authorization');
                preg_match('/Bearer\s(\S+)/', $token, $matches);
                $token = $matches[1];
            }else{
                $token = $request->header('access_token');
            }

            if (empty($token)){
                throw new ValidationException('AuthServiceProvider - Token nao informado!');            
            }            

            return User::where('access_token', $request->header('access_token'))->first();

        });
    }
}
