<?php

namespace Uniondrug\DrugstoreAuth;

use Phalcon\Di\ServiceProviderInterface;

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
