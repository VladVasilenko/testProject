<?php

namespace api\abstracts;

use Exception;
use InvalidArgumentException;
use yii\helpers\Json;

/**
 * Class AbstractResponse
 * @package api\abstracts
 */
abstract class AbstractResponse
{
    /**
     * @var AbstractDto|null
     */
    protected ?AbstractDto $model = null;

    /**
     * @var AbstractDto[]
     */
    private array $models = [];

    /**
     * @var boolean
     */
    private bool $isArrayOfModels = false;

    /**
     * @var boolean $isResultNullable
     */
    protected bool $isResultNullable = false;

    /**
     * @param AbstractDto|AbstractDto[] $dataObject
     */
    public function __construct($dataObject)
    {
        if ($dataObject instanceof AbstractDto) {
            // Модель
            $this->setModel($dataObject);
        } elseif (is_array($dataObject)) {
            // Массив моделей
            $this->setModelsFromArray($dataObject);
        } elseif (is_null($dataObject)) {
            $this->isResultNullable = true;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @param AbstractDto $dto
     */
    private function setModel(AbstractDto $dto): void
    {
        $this->model = $dto;
        $this->isArrayOfModels = false;
    }

    /**
     * @param array $models
     */
    private function setModelsFromArray(array $models): void
    {
        $this->isArrayOfModels = true;
        foreach ($models as $model) {
            if (!$model instanceof AbstractDto) {
                throw new InvalidArgumentException();
            }
            $this->models[] = $model;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toResult(): ?array
    {
        if ($this->isResultNullable) {
            return null;
        }

        if (!$this->isArrayOfModels) {
            return  $this->model->toArray();
        }

        return array_reduce($this->models, function ($result, $model) {
            $result[] = $model->toArray();

            return $result;
        });
    }

    /**
     * @return string
     * @throws Exception
     */
    public function toJson(): string
    {
        return Json::encode($this->toResult());
    }
}
