<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Словарик';

$langs = ['chv->ru', 'ru->chv'];
$script = <<< JS
$('#searchform-term').ime();
$('#chuvkeys').on( 'click', 'button', function(){
    var result = $('#searchform-term').val() + $(this).text();
    $('#searchform-term').val(result);
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-2"></div>
                <?php $form = ActiveForm::begin([
                    'id' => 'search-form',
                    'method' => 'get',
                    'action' => 'index.php',
                    'options' => [
                       /* 'class' => 'form-inline' */
                        ]
                    ]); ?>
            <div class="col-lg-2">
                 <div class="form-group">
                        <select id="searchform-lang" name="lang" class="form-control input-sm">
                            <option value="1"<?php echo ($lang == 1) ? 'selected' : ''?>>чув-&gt;рус</option>
                            <option value="2"<?php echo ($lang == 2) ? 'selected' : ''?>>рус-&gt;чув</option>
                        </select>
                    </div>
                    <div class="form-group" id="chuvkeys">
                        <button class="btn btn-default btn-sm" type="button">ă</button>
                        <button class="btn btn-default btn-sm" type="button">ĕ</button>
                        <button class="btn btn-default btn-sm" type="button">ç</button>
                        <button class="btn btn-default btn-sm" type="button">ÿ</button>
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" id="searchform-term" name="term" class="form-control input-lg" placeholder="Что искать..." value="<?php echo $str ? $str : ''; ?>" autofocus>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-lg" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>                    
                </div>
                <p class="help-block help-block-error">ă = 8, ĕ = 7, ç = 3, ÿ = 5.</p>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="col-lg-2"></div>
        </div>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                
            <?php 
                if(!empty($result)): ?>
                <table class="table result-tbl">
                    <tbody>
                    <?php
                    foreach($result as $r): ?>
                    <tr class="result-term">
                        <td><?php echo $r['fterm']; ?></td>
                        <td><?php echo $r['transcription']; ?></td>
                        <td><?php echo $r['lterm']; ?></td>
                        <td><?php echo Html::a('', ['edit', 'id1' => $r['fid'], 'id2' => $r['lid']], ['class' => 'glyphicon glyphicon-pencil']); ?></td>
                    </tr>
                    <tr class="result-examples">
                        <td colspan="4"><?php echo $r['examples']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
                </table>
            <?php endif; ?>

            </div>
            <div class="col-lg-2"></div>
        </div>

    </div>
</div>
