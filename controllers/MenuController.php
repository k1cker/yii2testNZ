<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use app\models\search\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReturn(){
        $model = Menu::getMenu();

        dump( $model);
    }
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {
            if ( empty($model->tree)) {
                $model->makeRoot();
            }elseif ($model->tree == 1){
                $model->makeRoot();

            } else {

                $menu = Menu::find()->where(['id' => $model->tree])->one();
                $model->appendTo($menu);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            $model->name     = $_POST['Menu']['name'];
            $parent_id       = $_POST['Menu']['parentId'];
            if($model->save()){
                if (!empty($parent_id))
                {
                    if ($model->id != $parent_id)
                    {
                        $parent = Menu::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }
                else
                {
                    if ( !$model->isRoot())
                        $model->makeRoot();
                }
            }


                return $this->redirect(['index']);
            }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->isRoot()){
            $model->deleteWithChildren();
        }else{
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
