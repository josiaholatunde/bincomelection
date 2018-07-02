<?php
/* @var $this yii\web\View */
?>
<?php if(Yii::$app->session->hasFlash('success') !== null) { ?>

<?php } ?>

<a class='btn btn-success btn-lg' href='index.php?r=announced-pu-results/create' >CREATE NEW POLLING UNIT</a>

<table class='table table-striped table-bordered'>
    <tr>
        <th><?= $model['entered_by_user'] ?></th>
    </tr>


</table>
