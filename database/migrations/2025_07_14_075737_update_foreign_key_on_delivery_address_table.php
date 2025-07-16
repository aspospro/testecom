<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyOnDeliveryAddressTable extends Migration
{
    public function up()
    {
        // 1. Get and drop the foreign key on address_id
        $foreignKey = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = 'delivery_address'
            AND COLUMN_NAME = 'address_id'
            AND CONSTRAINT_SCHEMA = DATABASE()
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if ($foreignKey && isset($foreignKey->CONSTRAINT_NAME)) {
            DB::statement("ALTER TABLE delivery_address DROP FOREIGN KEY `{$foreignKey->CONSTRAINT_NAME}`");
        }

        // 2. Rename the column using raw SQL
        DB::statement("ALTER TABLE delivery_address CHANGE address_id user_id BIGINT UNSIGNED");

        // 3. Add new foreign key constraint to users table
        Schema::table('delivery_address', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop foreign key on user_id
        $foreignKey = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = 'delivery_address'
            AND COLUMN_NAME = 'user_id'
            AND CONSTRAINT_SCHEMA = DATABASE()
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if ($foreignKey && isset($foreignKey->CONSTRAINT_NAME)) {
            DB::statement("ALTER TABLE delivery_address DROP FOREIGN KEY `{$foreignKey->CONSTRAINT_NAME}`");
        }

        // Rename column back
        DB::statement("ALTER TABLE delivery_address CHANGE user_id address_id BIGINT UNSIGNED");

        // Add old foreign key back to address table
        Schema::table('delivery_address', function ($table) {
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
        });
    }
}

