<?php

namespace Modules\Partner\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class TypeRelation extends BaseModel
{

    protected $fillable = ['partner_id', 'partner_types_id'];
    public $migrationDependancy = [];
    protected $table = "partner_type_relation";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('partner_id')->nullable()->index('partner_id');
        $table->unsignedInteger('partner_types_id')->nullable()->index('partner_types_id');
    }
}
