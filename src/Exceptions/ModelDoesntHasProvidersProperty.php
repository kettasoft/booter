<?php

namespace Scaffolding\Booter\Exceptions;

class ModelDoesntHasProvidersProperty extends \Exception
{
  public function __construct(string $model)
  {
    parent::__construct("The model ($model) Doesnt Has \$providers Property.");
  }
}