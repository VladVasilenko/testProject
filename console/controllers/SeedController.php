<?php

declare(strict_types=1);

namespace console\controllers;

use common\models\User\User;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionUsers()
    {
        $faker = \Faker\Factory::create();

       for ($i = 0; $i < 10; $i++) {
           $user = new User();
           $user->username = $faker->userName;
           $user->email = $faker->email;
           $user->setPassword($faker->password);
           $user->generateAuthKey();

           $user->save();
       }
        return ExitCode::OK;
    }
}