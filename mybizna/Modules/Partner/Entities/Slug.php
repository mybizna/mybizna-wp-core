<?php

namespace Modules\Partner\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

use Modules\Base\Classes\Migration;

class Slug extends BaseModel
{

    protected $fillable = ['partner_id', 'slug'];
    public $migrationDependancy = [];
    protected $table = "partner_slug";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->bigInteger('partner_id')->nullable()->index('partner_id');
        $table->string('slug')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('partner_slug', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }
    }
}
