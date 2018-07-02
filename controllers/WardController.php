<?php

namespace app\controllers;
use app\models\Ward;

class WardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLists($id)
    {

        $wards = Ward::find()
                    ->where(['lga_id'=>$id])
                    ->all();
            if(!empty($wards)) {
                foreach($wards as $ward) {
                      echo "<option value = '".$ward->ward_id."'>".$ward->ward_name."</option>";
                }
            } else{

                 echo "<option>-</option>";
                }       
    }

}
