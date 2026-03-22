<?php

namespace app\models;

use yii\db\ActiveRecord;

class Album extends ActiveRecord
{
    public static function tableName()
    {
        return 'album';
    }

    public function fields()
    {
        return ['id', 'title'];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['album_id' => 'id']);
    }
}
