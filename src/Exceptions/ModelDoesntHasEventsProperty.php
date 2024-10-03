<?php

namespace Scaffolding\Booter\Exceptions;

class ModelDoesntHasEventsProperty extends \Exception
{
  public function __construct(string $model)
  {
    parent::__construct("The model ($model) Doesnt Has \$events Property.");
  }
}
