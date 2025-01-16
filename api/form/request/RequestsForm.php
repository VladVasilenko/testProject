<?php

declare(strict_types=1);

namespace api\form\request;

use api\dto\request\request\CreateRequestDto;
use api\enum\request\RequestStatusEnum;
use common\models\Request\Request;
use yii\base\Model;

class RequestsForm extends Model
{
    public $user_id;
    public $amount;
    public $term;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'term'], 'required'],
            [['user_id', 'amount', 'term'], 'integer'],
            [
                'user_id',
                function ($attribute, $params) {
                    if ($this->user_id) {
                        $existModel = Request::find()->where(
                            ['user_id' => $this->user_id, 'status' => RequestStatusEnum::APPROVED]
                        )->one();
                        if ($existModel) {
                            $this->addError($attribute, 'Approved request already exists.');
                        }
                    }
                }
            ],
        ];
    }

    /**
     * @return CreateRequestDto
     */
    public function getData(): CreateRequestDto
    {
        return new CreateRequestDto((int)$this->user_id, (int)$this->amount, (int)$this->term);
    }
}