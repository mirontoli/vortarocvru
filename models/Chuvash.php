<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chuvash".
 *
 * @property integer $id
 * @property string $term
 */
class Chuvash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chuvash';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term'], 'required'],
            [['term'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term' => 'Term',
        ];
    }
}
