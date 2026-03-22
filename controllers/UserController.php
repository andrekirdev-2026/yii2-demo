<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use app\models\User;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionView($id): array
    {
        try {
            $user = User::find()
                ->with('albums')
                ->where(['id' => $id])
                ->one();
        } catch (\Exception $e) {
            throw new ServerErrorHttpException("Internal database error.");
        }

        if (!$user) {
            throw new NotFoundHttpException("Album not found.");
        }

        return $user->toArray([], ['albums']);
    }
}