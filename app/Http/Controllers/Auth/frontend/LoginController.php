<?php
namespace App\Http\Controllers\Auth\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class LoginController extends Controller
{
    // do login from frontend Nuxt App
    public function __invoke()
    {
        
        request()->validate([
            'password' => 'required',
            'email'    => 'required'
        ]);
        
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {
            $this->authenticateFrontend();
        }
    }

    // do login from frontend Nuxt App
    private function authenticateFrontend()
    {
        if (!Auth::guard('web')
            ->attempt(
                request()->only('email', 'password'),
                request()->boolean('remember')
            )) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
