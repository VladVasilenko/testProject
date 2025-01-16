<?php

declare(strict_types=1);

namespace api\form\request;

use api\dto\processor\request\StartProcessorDto;
use yii\base\Model;

class ProcessorForm extends Model
{
    public $delay;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delay'], 'required'],
            [['delay'], 'integer'],
        ];
    }

    /**
     * @return StartProcessorDto
     */
    public function getData(): StartProcessorDto
    {
        return new StartProcessorDto((int)$this->delay);
    }
}