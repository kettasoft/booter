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

    foreach(array_keys(self::$events) as $event) {
      if (in_array($event, $instance->getObservableEvents())) {
        self::$event(function (Model $model) use($event): void {
          self::dispatchBootProviders(self::$events[$event], $model);
        });
      }
    }
  }

  /**
   * Dispatch the event classes
   * @param array $events
   * @param mixed $model
   * @return void
   */
  protected static function dispatchBootProviders(array $events, $model): void
  {
    foreach($events as $event) {
      $resolver = resolve($event);

      if ($resolver instanceof HasBooterContract) {
        $resolver->handle($model);
      }
    }
  }

  /**
   * Check the model has events property.
   * @return bool
   */
  public static function checkModelHasProvidersProperty(): bool
  {
    return property_exists(self::class, 'events');
  }
}