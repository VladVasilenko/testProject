<?php

namespace api\controllers;

use api\abstracts\BaseApiController;
use api\dto\FailedValidationDto;
use api\form\request\ProcessorForm;
use api\services\request\RequestService;
use Exception;
use Yii;


/**
 * Site controller
 */
class ProcessorController extends BaseApiController
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
            'index' => ['GET'],
        ];
    }

    /**
     *
     * @return array
     * @throws Exception
     */
    public function actionIndex(RequestService $requestService)
    {
        $form = new ProcessorForm();
        $form->load(Yii::$app->request->get(), '');

        if (!$form->validate()) {
            return $this->response(new FailedValidationDto(), 400);
        }

        return $this->response($requestService->startProcess($form->getData()), 201);
    }
}
