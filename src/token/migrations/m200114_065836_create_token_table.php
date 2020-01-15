<?php

namespace claylua\token\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
class m200114_065836_create_token_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('access_token', [
      'id' => $this->primaryKey(),
      'user_id' => $this->integer()->notNull(),
      'status' => $this->integer()->defaultValue(1),
      'token' => $this->string(255)->notNull()->unique(),
      'updated_at' => $this->integer()->notNull(),
      'created_at' => $this->integer()->notNull()
    ]);
    // creates index for column `status`
    $this->createIndex(
      'idx-post-status',
      'access_token',
      'status'
    );

    // creates index for column `user_id`
    $this->createIndex(
      'idx-post-user_id',
      'access_token',
      'user_id'
    );
    // creates index for column `token`
    $this->createIndex(
      'idx-post-token',
      'access_token',
      'token'
    );
    // add foreign key for table `user`
    $this->addForeignKey(
      'fk-access_token-user_id',
      'access_token',
      'user_id',
      'user',
      'id',
      'CASCADE'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    // drops foreign key for table `user`
    $this->dropForeignKey(
      'fk-access_token-user_id',
      'access_token'
    );

    // drops index for column `token`
    $this->dropIndex(
      'idx-post-access_token',
      'token'
    );

    // drops index for column `user_id`
    $this->dropIndex(
      'idx-post-access_token',
      'user_id'
    );

    // drops index for column `status`
    $this->dropIndex(
      'idx-post-access_token',
      'status'
    );

    $this->dropTable('access_token');
  }
}

