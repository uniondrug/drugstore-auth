<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2021/9/14
 * Time: 9:43 AM
 */
namespace Uniondrug\DrugstoreAuth\Middleware;

use Phalcon\Http\RequestInterface;
use Uniondrug\DrugstoreAuth\Logic\DrugstoreAuthLogic;
use Uniondrug\DrugstoreAuth\Service\DrugstoreAuthService;
use Uniondrug\Middleware\DelegateInterface;
use Uniondrug\Middleware\Middleware;
use App\Errors\Error;

/**
 * Class LogMiddleware
 * @package Uniondrug\DrugstoreAuth\Middleware
 * @property \Uniondrug\DrugstoreAuth\Service\DrugstoreAuthService $drugstoreAuthService
 */
class LogMiddleware extends Middleware
{
    /**
     * @param RequestInterface  $request
     * @param DelegateInterface $next
     * @return \Phalcon\Http\ResponseInterface
     */
    public function handle(RequestInterface $request, DelegateInterface $next)
    {
        $token = $this->drugstoreAuthService->getTokenFromRequest($request);
        if (!$token) {
            return $next($request);
        }
        $url = $request->getURI();
        $this->di->getLogger('log')->info("请求开始：用户token【".$token."】接口域名【".$url."】");
        return $next($request);
    }
}