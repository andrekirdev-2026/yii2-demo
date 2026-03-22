<?php

namespace app\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use app\models\Album;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\Response;

class AlbumController extends ActiveController
{
    public $modelClass = Album::class;

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

    /**
     * GET /albums/{id}
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionView($id): array
    {
        try {
            $album = Album::find()
                ->with('photos')
                ->where(['id' => $id])
                ->one();
        } catch (\Exception $e) {
            throw new ServerErrorHttpException("Internal database error.");
        }

        if (!$album) {
            throw new NotFoundHttpException("Album not found");
        }

        return $album->toArray([], ['photos']);
    }
}