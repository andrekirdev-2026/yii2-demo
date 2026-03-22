<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%album}}`.
 */
class m260322_123424_create_album_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('album', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_album_user',
            'album',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_album_user', 'album');
        $this->dropTable('album');
    }
}
