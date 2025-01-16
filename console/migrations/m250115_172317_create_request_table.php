<?php

use api\enum\request\RequestStatusEnum;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%requests}}`.
 */
class m250115_172317_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'term' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'request_user_id_to_user_id',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id'
        );

        $this->createIndex(
            'request_user_id',
            '{{%request}}',
            'user_id',
        );


        $this->addTypes();

        $waiting = RequestStatusEnum::WAITING;
        $this->execute(
            "ALTER TABLE {{%request}} 
                ADD status request_status
                NOT NULL DEFAULT '{$waiting}';"
        );

        $approve = RequestStatusEnum::APPROVED;
        $this->execute("CREATE UNIQUE INDEX request_approved_status_unique ON request (user_id, status)
            WHERE (status = '{$approve}')");
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('request_user_id', '{{%request}}');
        $this->dropForeignKey('request_user_id_to_user_id', '{{%request}}');
        $this->dropTable('{{%requests}}');
        $this->dropTypes();
    }

    /**
     * @return void
     */
    private function addTypes(): void
    {
        $approved = RequestStatusEnum::APPROVED;
        $declined = RequestStatusEnum::DECLINED;
        $waiting = RequestStatusEnum::WAITING;
        $this->execute(
            "CREATE TYPE request_status AS ENUM (
            '{$approved}', 
            '{$declined}',
            '{$waiting}'
        );"
        );
    }

    /**
     * @return void
     */
    private function dropTypes(): void
    {
        $this->execute("DROP TYPE IF EXISTS request_status");
    }
}
