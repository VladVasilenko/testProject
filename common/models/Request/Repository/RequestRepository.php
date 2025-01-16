<?php

declare(strict_types=1);

namespace common\models\Request\Repository;

use api\enum\request\RequestStatusEnum;
use common\models\Request\Request;
use mhndev\yii2Repository\AbstractSqlArRepository;
use mhndev\yii2Repository\Traits\SqlArRepositoryTrait;

class RequestRepository extends AbstractSqlArRepository implements RequestRepositoryInterface
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
     * @return Request[]
     */
    public function getAllWaitingRequests(): array
    {
        return $this->model->find()->where(['status' => RequestStatusEnum::WAITING])->all();
    }

}