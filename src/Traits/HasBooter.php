<?php

namespace Scaffolding\Booter\Traits;

use Scaffolding\Booter\HasBooter as HasBooterAbstract;
use Illuminate\Database\Eloquent\Model;
use Scaffolding\Booter\Contracts\EventShouldQueue;
use Scaffolding\Booter\Exceptions\ModelDoesntHasEventsProperty;

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
      throw new ModelDoesntHasEventsProperty(self::class);
    }

    parent::boot();

    foreach (static::getModelEvents() as $event => $handlers) {
      static::registerModelEvent($event, function (Model $model) use ($handlers) {
        static::dispatchBootHandlers($handlers, $model);
      });
    }
  }

  /**
   * Dispatch the event handlers for the given events
   * @param array<HasBooterAbstract> $events
   * @param mixed $model
   * @return void
   */
  protected static function dispatchBootHandlers(array $events, Model $model): void
  {
    foreach ($events as $event) {
      $handler = $event::getInstance();

      if ($handler instanceof HasBooterAbstract) {

        if ($handler instanceof EventShouldQueue) {
          dispatch(function () use ($handler, $model): void {
            $handler->handle($model);
          });
        }

        /**
         * Invoke the given handler without queue.
         */
        else {
          $handler->handle($model);
        }
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

  /**
   * Get the model's event-to-class mappings, including config mappings.
   *
   * @return array
   */
  protected static function getModelEvents(): array
  {
    return array_merge(
      config('booter.mappings.' . static::class, []),
      static::$events ?? []
    );
  }
}
