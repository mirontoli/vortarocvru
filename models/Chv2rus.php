<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chv2ru".
 *
 * @property integer $chv_id
 * @property integer $rus_id
 * @property string $examples
 */
class Chv2rus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chv2ru';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chv_id', 'rus_id', 'examples'], 'required'],
            [['chv_id', 'rus_id'], 'integer'],
            [['examples'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chv_id' => 'Chv ID',
            'rus_id' => 'Rus ID',
            'examples' => 'Examples',
        ];
    }
}
