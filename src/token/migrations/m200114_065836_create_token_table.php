<?php

/*
 * Copyright (c) 2020, Clay Lua <czeeyong@gmail.com>
 * Author: Clay Lua <czeeyong@gmail.com>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

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

