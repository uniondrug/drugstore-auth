<?php

namespace Uniondrug\DrugstoreAuth;

use Phalcon\Di\ServiceProviderInterface;
use Uniondrug\DrugstoreAuth\Service\DrugstoreAuthService;

/**
 * Class DrugstoreAuthProvider
 * @package Uniondrug\DrugstoreAuth
 */
class DrugstoreAuthProvider implements ServiceProviderInterface
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->set(
            'drugstoreAuthService',
            function () {
                return new DrugstoreAuthService();
            }
        );
    }
}
