<?php

namespace app\commands;

use yii\console\Controller;
use app\models\User;
use app\models\Album;
use app\models\Photo;
use Yii;

class SeedController extends Controller
{
    public function actionRun()
    {
        $this->stdout("Seeding users...\n");
        $this->seedUsers();

        $this->stdout("Seeding albums...\n");
        $this->seedAlbums();

        $this->stdout("Seeding photos...\n");
        $this->seedPhotos(1000);

        $this->stdout("Seeding complete!\n");
    }

    private function seedUsers(): void
    {
        $password = Yii::$app->params['demoPassword'] ?? 'demo1234';

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->first_name = "user_{$i}_fname";
            $user->last_name = "user_{$i}_lname";
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);
            $user->save(false);
        }
    }

    private function seedAlbums(): void
    {
        $userIds = User::find()->select('id')->column();
        for ($i = 1; $i <= 100; $i++) {
            $album = new Album();
            $album->user_id = $userIds[array_rand($userIds)];
            $album->title = "album_{$i}";
            $album->save(false);
        }
    }

    private function seedPhotos($count): void
    {
        $albumIds = Album::find()->select('id')->column();
        for ($i = 1; $i <= $count; $i++) {
            $photo = new Photo();
            $photo->album_id = $albumIds[array_rand($albumIds)];
            $photo->title = "photo_{$i}";
            $photo->save(false);
        }
    }
}
