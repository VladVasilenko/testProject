<?php

namespace api\controllers;

use api\abstracts\BaseApiController;
use api\dto\FailedValidationDto;
use api\form\request\RequestsForm;
use api\services\request\RequestService;
use Exception;
use Yii;


/**
 * Site controller
 */
class RequestsController extends BaseApiController
{
    protected array $actionsWithoutLogin = [
        'index'
    ];
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    protected function verbs()
    {
        return [
            'index' => ['POST'],
        ];
    }

    /**
     *
     * @return array
     * @throws Exception
     */
    public function actionIndex(RequestService $requestService)
    {
        $form = new RequestsForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->validate()) {
            return $this->response(new FailedValidationDto(), 400);
        }

        return $this->response($requestService->saveRequest($form->getData()), 201);
    }
}
