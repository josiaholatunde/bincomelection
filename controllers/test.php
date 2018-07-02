<?php



public function actionIndex()
    {
    $model = new PollingUnit();

        if ($model->load(Yii::$app->request->post())) {
          if ($model->validate()) {
            // form inputs are valid, do something here
            return;
            }
        }

        return $this->render('index', [
         'model' => $model,
            ]);
    }

    public function actionSum()
    {
    $model = new PollingUnit();

        if ($model->load(Yii::$app->request->post())) {
          if ($model->validate()) {
            // form inputs are valid, do something here
            return;
            }
        }

        return $this->render('display', [
         'model' => $model,
            ]);
    }

    public function actionSumm($id)
    {
    $query = new \yii\db\Query();
    $rows = $query->select(['polling_unit.lga_id',
                    'announced_pu_results.party_abbreviation',
                    'announced_pu_results.party_score'])
         ->from('polling_unit')
         ->join('join','announced_pu_results','announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid')
         ->all();

    //$rows2 = $rows->find()->where(['announced_pu_results.lga_id'=>$id])->all();
    var_dump($rows);die();

        if ($model->load(Yii::$app->request->post())) {
          if ($model->validate()) {
            // form inputs are valid, do something here
            return;
            }
        }

        return $this->render('display', [
         'model' => $model,
            ]);
    }

    /**
     * Displays a single PollingUnit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PollingUnit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PollingUnit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uniqueid]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PollingUnit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uniqueid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PollingUnit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionLists($id)
    {

        $polling_units = PollingUnit::find()
                    ->where(['ward_id'=>$id])
                    ->all();
            if(!empty($polling_units)) {
                foreach($polling_units as $polling_unit) {
                      echo "<option value = '".$polling_unit->uniqueid."'>".$polling_unit->polling_unit_name."</option>";
                }
            } else{

                 echo "<option>-</option>";
                }       
    }

    public function actionDisplay($id) 
    {
        $pus = AnnouncedPuResults::find()
            ->where(['polling_unit_uniqueid'=>$id])
            ->all();

            if(!empty($pus)) {
                $msg = "<table class='table table-bordered table-striped'><tr><td colspan='2'><h3>Individual Polling Unit Result</h3></td></tr><tr><th>Party Name</th>
                <th>Party Score</th></tr>";
                foreach($pus as $pu) {
                      $msg.= "<tr><td>".$pu->party_abbreviation." </td><td> ".$pu->party_score."</td></tr>";
                }
                $msg.= "</table>";
                echo $msg;
            } else{

                 echo "<div class='alert alert-danger'>No result found</div>";
                }  

        

    }

    /**
     * Finds the PollingUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PollingUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PollingUnit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

?>