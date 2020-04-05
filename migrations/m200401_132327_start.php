<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m200401_132327_start
 */
class m200401_132327_start extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ]);

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar_path' => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale' => $this->string(32)->notNull(),
            'gender' => $this->smallInteger(1)
        ]);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%film}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'genre_id' =>$this->integer(),
            'body' => $this->text()->notNull(),
            'popularity_rating' =>$this->integer(),
            'img_path' => $this->string(1024)->defaultValue(null),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('{{%film_genre}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('{{%seance}}', [
            'id' => $this->primaryKey(),
            'film_id' => $this->integer()->notNull(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull(),
            'cinema_places' => $this->text(),
            'seance_time' => $this->integer()->notNull(),
            'seance_date' =>$this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_film', '{{%seance}}', 'film_id', '{{%film}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_film_genre', '{{%film}}', 'genre_id', '{{%film_genre}}', 'id', 'cascade', 'cascade');

    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropForeignKey('fk_film', '{{%seance}}');
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropForeignKey('fk_film_genre', '{{%film}}');
        $this->dropTable('{{%film}}');
        $this->dropTable('{{%seance}}');
        $this->dropTable('{{%film_genre}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%user_profile}}');
    }
}
