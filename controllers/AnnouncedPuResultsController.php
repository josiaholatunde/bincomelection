<?php

namespace app\controllers;

use Yii;
use app\models\Model;
use app\models\PollingUnit;
use app\models\AnnouncedPuResults;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

class AnnouncedPuResultsController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new PollingUnit();
        $modelsPuResult = [new AnnouncedPuResults];

        if ($model->load(Yii::$app->request->post())) {

            $modelsPuResult = Model::createMultiple(AnnouncedPuResults::classname());
            Model::loadMultiple($modelsPuResult, Yii::$app->request->post());

           

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPuResult) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPuResult as $modelPuResult) {
                            $modelPuResult->polling_unit_uniqueid = $model->uniqueid;
                            if (! ($flag = $modelPuResult->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success','Polling unit was added successfully');

                        return $this->redirect(['create', 'id' => $model->uniqueid]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsPuResult' => (empty($modelsPuResult)) ? [new AnnouncedPuResults] : $modelsPuResult
        ]);
    }

    public function actionView($id)
    {
        $model = new AnnouncedPuResults();
        if(isset($_POST)){
            
        }
        return $this->render('view',['model'=> $model]);
    }

}
