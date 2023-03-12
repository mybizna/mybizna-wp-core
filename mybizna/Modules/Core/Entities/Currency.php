<?php

namespace Modules\Core\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Base\Classes\Migration;

class Currency extends BaseModel
{
    protected $table = 'core_currency';

    public $migrationDependancy = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
     "name", "code", "symbol", "rate",'is_system',
        "buying", "selling", "published", "is_fetched",
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */



    /**
     * Get the user that created the record.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that created the record.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that created the record.
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByCreatedAt($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name', 255);
        $table->string('code', 255)->nullable()->default(null);
        $table->string('symbol', 255)->nullable()->default(null);
        $table->decimal('rate', 11, 2)->nullable()->default(null);
        $table->decimal('buying', 11, 2)->nullable()->default(null);
        $table->decimal('selling', 11, 2)->nullable()->default(null);
        $table->integer('published')->nullable()->default(0);
        $table->integer('is_fetched')->nullable()->default(0);
        $table->tinyInteger('is_system')->default(false);
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('core_currency', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('core_country')->nullOnDelete();
        }
    }


    public function deleteRecord($id)
    {

        $currency = $this->where('id', $id)->first();

        if ($currency->is_system) {
            return [
                'module' => $this->module,
                'model' => $this->model,
                'status' => 0,
                'error' => 1,
                'record' => [],
                'message' => 'You can not Delete a Currency Set by system..',
            ];
        }

        parent::deleteRecord($id);

    }
}
