<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUIDs
{
	/**
	 * Generate UUID
	 * @return atribute 
     */
    public static function boot()
    {
        parent::boot();

        static::bootUUIDs();
    }

    /**
     * Get the primary key for the model.
     * This method is overridden to ensure that the primary key is a UUID.
     *
     * @return string
     */
    public function getKeyName(){
        
        return 'id';
    }

    /**
     * Get the primary key value for the model.
     * This method is overridden to ensure that the primary key is a UUID.
     *
     * @return string
     */
    public function getKey()
    {
        return (string) $this->{$this->getKeyName()};
    }

    /**
     * Get the primary key type for the model.
     * This method is overridden to ensure that the primary key is a string.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Boot the UUID trait for the model.
     * This method is called when the model is being created.
     * It generates a UUID for the model's primary key if it is not already set.
	 */
   /* protected static function bootUUIDs()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Changes the attribute of the eloquent
     * @return atribute
     */
   /* public function getIncrementing()
    {
        return false;
    }

    /**
     * Changes the attribute of the eloquent
     * @return atribute
     */
   /* public function getKeyType()
    {
        return 'string';
    } */
} 

