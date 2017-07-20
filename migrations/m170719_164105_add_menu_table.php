<?php

use yii\db\Migration;

class m170719_164105_add_menu_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string(),
            'link' => $this->string(255),
        ]);
    }


}
