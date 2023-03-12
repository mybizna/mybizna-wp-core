<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;
use Modules\Base\Entities\BaseModel;

class Partner extends BaseModel
{

    protected $fillable = [
        'user_id', 'first_name', 'last_name', "type_str", 'company', 'email', 'phone', 'mobile', 'other', 'website',
        'fax', 'notes', 'address', 'city', 'state', 'postal_code',
        'country_id', 'currency_id', 'life_stage', 'hash',
    ];
    public $migrationDependancy = [];
    protected $table = "partner";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
        $table->string('first_name', 60)->nullable();
        $table->string('last_name', 60)->nullable();
        $table->enum('type_str', ['customer', 'suppier'])->default('customer')->nullable();
        $table->string('company', 60)->nullable();
        $table->string('email', 100)->nullable()->index('email');
        $table->string('phone', 100)->nullable();
        $table->string('mobile', 100)->nullable();
        $table->string('other', 50)->nullable();
        $table->string('website', 100)->nullable();
        $table->string('fax', 20)->nullable();
        $table->text('notes')->nullable();
        $table->string('address')->nullable();
        $table->string('city', 80)->nullable();
        $table->string('state', 50)->nullable();
        $table->string('postal_code', 10)->nullable();
        $table->integer('country_id')->nullable();
        $table->integer('currency_id')->nullable();
        $table->string('life_stage')->nullable();
        $table->string('hash', 40)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('partner', 'user_id')) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        }
        if (Migration::checkKeyExist('partner', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('core_country')->nullOnDelete();
        }
        if (Migration::checkKeyExist('partner', 'currency_id')) {
            $table->foreign('currency_id')->references('id')->on('core_currency')->nullOnDelete();
        }
    }
}
