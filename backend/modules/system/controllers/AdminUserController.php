<?php

namespace backend\modules\system\controllers;

use common\models\Model;
use Yii;
use common\helpers\Helper;
use common\models\admin\AdminUser;
use common\models\admin\search\AdminUserSearch;
use common\controllers\BaseRestController;
use yii\base\Arrayable;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends ActiveController
{
    public $modelClass = AdminUser::class;

    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'backend\actions\IndexAction',
                'modelClass' => AdminUserSearch::class,
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
            ],
            'delete' => [
                'class' => 'yii\rest\DeleteAction',
                'modelClass' => $this->modelClass,
            ],
        ];
    }
//    /**
//     * @var AdminUser
//     */
//    public $modelClass = AdminUser::class;
//
//    /**
//     * Lists all AdminUser models.
//     */
//    public function actionIndex()
//    {
//        $searchModel = new AdminUserSearch();
//        $x = $searchModel->search($this->request->queryParams);
//        return $x->getModels();
//    }

//    public function actionView($id)
//    {
//        return AdminUser::find()->with('roles')->one();
//    }
//
//    /**
//     * Displays a single AdminUser model.
//     * @param int $id ID
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionView(int $id): Model
//    {
//        return $this->findModel($id);
//    }
//
//    /**
//     * Creates a new AdminUser model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        if ($this->modelClass->load($this->request->post()) && $this->modelClass->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//        $model = new AdminUser();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Updates an existing AdminUser model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param int $id ID
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing AdminUser model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param int $id ID
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
}
