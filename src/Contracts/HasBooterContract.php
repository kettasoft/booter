<?php

namespace Scaffolding\Booter\Contracts;

use Illuminate\Database\Eloquent\Model;

interface HasBooterContract
{
  /**
   * Handle the event
   * @param Model $model
   * @return void
   */
  public function handle(Model $model);
}