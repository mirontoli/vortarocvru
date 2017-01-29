<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "russian".
 *
 * @property integer $id
 * @property string $term
 */
class Russian extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'russian';
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
