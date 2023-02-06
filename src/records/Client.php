<?php
namespace verbb\consume\records;

use craft\db\ActiveRecord;

class Client extends ActiveRecord
{
    // Public Methods
    // =========================================================================

    public static function tableName(): string
    {
        return '{{%consume_clients}}';
    }
}
