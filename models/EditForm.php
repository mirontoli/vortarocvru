<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditForm extends Model
{
    public $chvterm;
    public $rusterm;
    public $transcription;
    public $examples;

    public function rules()
    {
        return [
            [['chvterm', 'rusterm', 'transcription', 'examples'], 'required'],
            [['chvterm', 'rusterm', 'transcription', 'examples'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'chvterm' => 'Чувашское слово',
            'rusterm' => 'Русский перевод',
            'transcription' => 'Транскрипция',
            'examples' => 'Примеры применения',
        ];
    }
}
