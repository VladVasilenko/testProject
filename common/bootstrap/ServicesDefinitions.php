<?php

declare(strict_types=1);

namespace common\bootstrap;

use api\services\request\RequestService;
use common\models\Request\Repository\RequestRepository;
use common\models\Request\Repository\RequestRepositoryInterface;
use common\models\Request\Request;
use common\models\User\Repository\UserRepository;
use common\models\User\Repository\UserRepositoryInterface;
use common\models\User\User;
use yii\base\BootstrapInterface;

class ServicesDefinitions implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->set(RequestRepositoryInterface::class, [
            'class' => RequestRepository::class
        ]);

        $app->set(RequestRepository::class, function () {
            return new RequestRepository(new Request());
        });

        $app->set(UserRepositoryInterface::class, [
            'class' => UserRepository::class
        ]);

        $app->set(UserRepository::class, function () {
            return new UserRepository(new User());
        });

        $app->set(RequestService::class, new RequestService($app->get(RequestRepository::class), $app->get(UserRepository::class)));
    }
}