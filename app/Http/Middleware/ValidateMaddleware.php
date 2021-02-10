<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class ValidateMaddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $model
     * @return mixed
     * @throws BindingResolutionException
     */
    public function handle($request, Closure $next, $model)
    {
        $myModel = app($model);
        $validator = app('validator')->make($request->input(), $myModel->rules($request));

        if ($validator->fails()) {

            return Response()->json($validator->errors(), 422);
        }
        return $next($request);
    }

}
