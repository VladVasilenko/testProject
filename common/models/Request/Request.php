<?php

namespace common\models\Request;

use api\enum\request\RequestStatusEnum;
use common\models\User\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $term
 * @property string $status
 * @property User $user
 */
class Request extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => RequestStatusEnum::WAITING],
            ['status', 'in', 'range' => [RequestStatusEnum::WAITING, RequestStatusEnum::APPROVED, RequestStatusEnum::DECLINED]],
        ];
    }

    public function safeAttributes()
    {
        return ['user_id', 'amount', 'term', 'status'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getTerm(): int
    {
        return $this->term;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
