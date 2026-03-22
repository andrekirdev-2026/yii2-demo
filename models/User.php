<?php
namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function getAlbums(): ActiveQuery
    {
        return $this->hasMany(Album::class, ['user_id' => 'id']);
    }

    public function fields(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
        ];
    }
}