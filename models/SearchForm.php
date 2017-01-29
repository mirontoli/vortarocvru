<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $term;
    public $lang;

    public function rules()
    {
        return [
            [['term', 'lang'], 'required'],
            ['term', 'string'],
            ['lang', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'term' => 'Термин',
            'lang' => 'Язык',
        ];
    }
}
