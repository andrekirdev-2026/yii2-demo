<?php

namespace app\models;

use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{
    private static array $images = [
        '/images/photos/1.jpg',
        '/images/photos/2.jpg',
        '/images/photos/3.jpg',
        '/images/photos/4.jpg',
        '/images/photos/5.jpg',
        '/images/photos/6.jpg',
        '/images/photos/7.jpg',
        '/images/photos/8.jpg',
    ];

    public function fields(): array
    {
        return [
            'id',
            'album_id',
            'title',
            'url',
        ];
    }

    public function getUrl(): string
    {
        $index = array_rand(self::$images);
        return \Yii::getAlias('@web') . self::$images[$index];
    }
}