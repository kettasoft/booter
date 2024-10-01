<?php

namespace Scaffolding\Booter\Traits;

use Illuminate\Database\Eloquent\Model;
use Scaffolding\Booter\Contracts\HasBooterContract;
use Scaffolding\Booter\Exceptions\ModelDoesntHasProvidersProperty;

trait HasBooter
{
  /**
     * Bootstrap the model.
     *
     * @return void
     */
  public static function boot(): void 
  {
    if (! self::checkModelHasProvidersProperty()) {
      throw new ModelDoesntHasProvidersProperty(self::class);
    }

    parent::boot();

    $instance = new static;

    foreach(array_keys(self::$providers) as $provider) {
      if (in_array($provider, $instance->getObservableEvents())) {
        self::$provider(function (Model $model) use($provider): void {
          self::dispatchBootProviders(self::$providers[$provider], $model);
        });
      }
    }
  }

  /**
   * Dispatch the provider classes
   * @param array $providers
   * @param mixed $model
   * @return void
   */
  protected static function dispatchBootProviders(array $providers, $model): void
  {
    foreach($providers as $provider) {
      $resolver = resolve($provider);

      if ($resolver instanceof HasBooterContract) {
        $resolver->handle($model);
      }
    }
  }

  /**
   * Check the model has providers property.
   * @return bool
   */
  public static function checkModelHasProvidersProperty(): bool
  {
    return property_exists(self::class, 'providers');
  }
}