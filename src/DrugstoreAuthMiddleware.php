<?php
/**
 * 基于TOKEN的认证方式。
 */
namespace Uniondrug\DrugstoreAuth;

use Phalcon\Http\RequestInterface;
use Uniondrug\Middleware\DelegateInterface;
use Uniondrug\Middleware\Middleware;

/**
 * Class TokenAuthMiddleware
 * @package Uniondrug\TokenAuthMiddleware
 * @property \Uniondrug\TokenAuthMiddleware\TokenAuthService $tokenAuthService
 */
class DrugstoreAuthMiddleware extends Middleware
{
    public function handle(RequestInterface $request, DelegateInterface $next)
    {
        echo 1;die;
        return $next($request);
    }
}
