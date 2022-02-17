<?php
namespace Insyghts\Authentication\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        // echo '<pre>'; print_r('permission'); exit;


           $user= app('loginUser')->getUser();
        //    echo '<pre>'; print_r($user); exit;


            if ($user->can($permission)) {
echo '<pre>'; print_r('here'); exit;

                return $next($request);
            }
        // }
// echo '<pre>'; print_r('Not allowed'); exit;

        // return $request->ajax ? response('Unauthorized.', 401) : redirect('/login');
    }
}
