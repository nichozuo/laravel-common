<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 6:04 PM
 */

namespace Nichozuo\LaravelCommon\Auth;


use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

trait AuthTrait
{
    protected $guard_name = '';

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'msg' => 'ok',
            'code' => 1,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->guard($this->guard_name)->factory()->getTTL() * 60,
                'expires_at' => Carbon::now()->addDay(100)->timestamp
            ]
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->guard($this->guard_name)->user();

        return response()->json([
            'msg' => 'ok',
            'code' => 1,
            'data' => [
                'id' => Hashids::encode($user->id),
                'username' => $user->username,
                'realname' => $user->realname
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard($this->guard_name)->logout(true);

        return response()->json([
            'msg' => 'ok',
            'code' => 1,
            'data' => null,
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard($this->guard_name)->refresh(true, true));
    }
}