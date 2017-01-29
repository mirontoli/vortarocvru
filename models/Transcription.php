<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transcription".
 *
 * @property integer $id
 * @property string $value
 * @property integer $chv_id
 */
class Transcription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transcription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'chv_id'], 'required'],
            [['chv_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'chv_id' => 'Chv ID',
        ];
    }
}
