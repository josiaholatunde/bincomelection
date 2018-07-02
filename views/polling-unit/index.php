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
    <h2>Polling Unit Results for Delta State</h2>
</div>

    <?php $form = ActiveForm::begin(); ?>

         <?= $form->field($model, 'lga_id')->dropdownList(
         ArrayHelper::map(Lga::find()->all(),'lga_id','lga_name'),[
             'prompt'=>'Select the Local Government Area',
             'onchange'=>'
                    $.post("index.php?r=ward/lists&id='.'"+$(this).val(), 
                                function(data) {
                              $("select#ward" ).html( data );
                            });
                        ']);
         ?>
        
        <?= $form->field($model, 'ward_id')->dropdownList(
             [],[
             'prompt'=>'Select the Ward',
             'id' => 'ward',
             'onchange'=>'
                    $.post("index.php?r=polling-unit/lists&id='.'"+$(this).val(), 
                                function(data) {
                              $("select#pu" ).html( data );
                            });
                        ']);
         ?>
        
        <?= $form->field($model, 'polling_unit_id')->dropdownList(
             [],[
             'prompt'=>'Select the Polling Unit',
             'id' => 'pu',
             'onchange'=>'
                    $.post("index.php?r=polling-unit/display&id='.'"+$(this).val(), 
                                function(data) {
                              $("#result" ).html( data );
                            });
                        ']);
         ?>

        
       <div id='result'></div>
    
        
    <?php ActiveForm::end(); ?>

</div><!-- polling-unit-index -->
