<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-edit">

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

                    <?= $form->field($model, 'chvterm')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'rusterm')->textInput() ?>

                    <?= $form->field($model, 'transcription')->textInput() ?>

                    <?= $form->field($model, 'examples')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Edit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-lg-2"></div>
        </div>
</div>
