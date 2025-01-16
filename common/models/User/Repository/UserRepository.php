<?php

declare(strict_types=1);

namespace common\models\User\Repository;

use api\enum\request\RequestStatusEnum;
use common\models\Request\Repository\RequestRepositoryInterface;
use common\models\Request\Request;
use mhndev\yii2Repository\AbstractSqlArRepository;
use mhndev\yii2Repository\Traits\SqlArRepositoryTrait;

class UserRepository extends AbstractSqlArRepository implements RequestRepositoryInterface
{
    const PRIMARY_KEY = 'id';

    const APPLICATION_KEY = 'id';


    use SqlArRepositoryTrait {
        init as repositoryInit;
    }

    public function init()
    {
        parent::init();

        $this->repositoryInit();
    }

    /**
     * @param  int  $userId
     * @return bool
     */
    public function hasApprovedRequest(int $userId): bool
    {
        return $this->model->find()->joinWith('requests')->where(['request.status' => RequestStatusEnum::APPROVED, 'user_id' => $userId])->exists();
    }

}