<?php
/**
 * TokenAuthService.php
 */
namespace Uniondrug\DrugstoreAuth;

use Phalcon\Config;
use Phalcon\Http\RequestInterface;
use Uniondrug\Framework\Services\Service;

class DrugstoreAuthService extends Service
{
    public function checkIsWhite($url)
    {
        $whiteController = $this->router->getControllerName();
        $whiteControllerList = $this->config->path('drugAuth.whiteController');
        if (in_array($whiteController, $whiteControllerList)) {
            return true;
        }
        $actionName = $this->router->getActionName();
        
    }
}
