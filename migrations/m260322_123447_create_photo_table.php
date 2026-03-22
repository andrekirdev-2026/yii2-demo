<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photo}}`.
 */
class m260322_123447_create_photo_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('photo', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_photo_album',
            'photo',
            'album_id',
            'album',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_photo_album', 'photo');
        $this->dropTable('photo');
    }
}
