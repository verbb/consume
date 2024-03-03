<?php
namespace verbb\consume\migrations;

use verbb\consume\Consume;

use Craft;
use craft\db\Migration;

use verbb\auth\Auth;

class Install extends Migration
{
    // Public Methods
    // =========================================================================

    public function safeUp(): bool
    {
        // Ensure that the Auth module kicks off setting up tables
        // Use `Auth::getInstance()` not `Auth::$plugin` as it doesn't seem to work well in migrations
        Auth::getInstance()->migrator->up();

        $this->createTables();
        $this->createIndexes();

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTables();

        // Delete all tokens for this plugin
        Auth::$plugin->getTokens()->deleteTokensByOwner('consume');

        return true;
    }

    public function createTables(): void
    {
        $this->archiveTableIfExists('{{%consume_clients}}');
        $this->createTable('{{%consume_clients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'handle' => $this->string()->notNull(),
            'enabled' => $this->boolean(),
            'type' => $this->string()->notNull(),
            'settings' => $this->text(),
            'sortOrder' => $this->smallInteger()->unsigned(),
            'cache' => $this->text(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);
    }

    public function createIndexes(): void
    {
        $this->createIndex(null, '{{%consume_clients}}', ['name'], true);
        $this->createIndex(null, '{{%consume_clients}}', ['handle'], true);
    }

    public function dropTables(): void
    {
        $this->dropTableIfExists('{{%consume_clients}}');
    }
}
