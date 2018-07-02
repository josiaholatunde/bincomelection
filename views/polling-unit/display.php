<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Lga;

/* @var $this yii\web\View */
/* @var $model app\models\PollingUnit */
/* @var $form ActiveForm */
?>
<div class="polling-unit-index">
<div class='page-header'>
    <h2>Sum of Polling Unit Results for Selected Local Governments in Delta State</h2>
</div>

    <?php $form = ActiveForm::begin(); ?>

         <?= $form->field($model, 'lga_id')->dropdownList(
         ArrayHelper::map(Lga::find()->all(),'lga_id','lga_name'),[
             'prompt'=>'Select the Local Government Area',
             'onchange'=>'
                    $.post("index.php?r=polling-unit/summ&id='.'"+$(this).val(), 
                                function(data) {
                              $("select#ward" ).html( data );
                            });
                        ']);
         ?>
        
   

        
       <div id='result'></div>
    
        
    <?php ActiveForm::end(); ?>

</div><!-- polling-unit-index -->
