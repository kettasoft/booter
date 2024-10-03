<?php

namespace Scaffolding\Booter;

use Illuminate\Database\Eloquent\Model;

abstract class HasBooter
{
  protected static $instance;

  /**
   * Prevent instantiation of the contract.
   */
  private function __construct()
  {
    // 
  }

  /**
   * Get the singleton instance of the contract
   * @return HasBooter
   */
  public static function getInstance(): HasBooter
  {
    if (!isset(static::$instance)) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  /**
   * Handle the event
   * @param Model $model
   * @return void
   */
  abstract public function handle(Model $model);
}
