<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Party;
use app\models\Ward;
use app\models\Lga;
?>

<div class="election-form">

<?php if(Yii::$app->session->hasFlash('success') !== null) { ?>

<?php } ?>
<div class='page-header'>
    <h2>Create New Polling Unit</h2>
</div>

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'polling_unit_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'polling_unit_number')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'polling_unit_description')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'polling_unit_id')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6">
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
        
        
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, "ward_id")->dropdownList(
         [],[
             'prompt'=>'Select the Ward',
             'id'=>'ward'
             ]);
        ?>
        </div>

        <div class="col-sm-6">
        <?= $form->field($model, "uniquewardid")->textInput();
        ?>
        </div>

        <div class="col-sm-6">
        <?= $form->field($model, "lat")->textInput();
        ?>
        </div>

        <div class="col-sm-6">
        <?= $form->field($model, "long")->textInput();
        ?>
        </div>
    </div>  
    



    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> Store Polling Unit Results
                
            </h4>
        </div>
        <div class="panel-body">

            <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 12, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsPuResult[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'party_abbreviation',
            'party_score',
            'entered_by_user',
            'date_entered',
            'user_ip_address',
            
        ],
    ]); ?>


            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelsPuResult as $i => $modelPuResult): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Polling Units</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-info btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">

                        
                        <?= $form->field($modelPuResult, "[{$i}]party_abbreviation")->dropdownList(
         ArrayHelper::map(Party::find()->all(),'partyid','partyname'),[
             'prompt'=>'Select the Party',
             ]);
             ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelPuResult, "[{$i}]party_score")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelPuResult, "[{$i}]entered_by_user")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                      
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton('Create' , ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>