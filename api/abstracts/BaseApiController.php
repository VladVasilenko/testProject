<?php

declare(strict_types=1);

namespace api\abstracts;

use api\components\Response\Response;
use Exception;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

abstract class BaseApiController extends Controller
{
    /**
     * @var array $actionsWithoutLogin
     */
    protected array $actionsWithoutLogin = [];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    /**
     * Declares the allowed Auth methods.
     * Please refer to [[CompositeAuth::authMethods]] on how to declare the allowed methods.
     * @return array the allowed Auth methods.
     */
    protected function authMethods(): array
    {
        return in_array(Yii::$app->controller->action->id, $this->actionsWithoutLogin) ? [] : [
            HttpBearerAuth::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class'       => CompositeAuth::class,
                'authMethods' => $this->authMethods(),
            ],
            [
                'class'   => VerbFilter::class,
                'actions' => $this->verbs(),
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * @param $data
     * @param  int  $code
     * @return array
     * @throws Exception
     */
    protected function response($data, int $code = 200): array
    {
        $response = new Response($data);
        Yii::$app->response->statusCode = $code;
        return $response->toResult();
    }
}