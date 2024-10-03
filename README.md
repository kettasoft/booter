# Laravel Model Event Booter

**Laravel Model Event Booter** is a package that simplifies managing model events in Laravel by allowing you to define and map model events (e.g., `created`, `updated`, `deleted`, etc.) to custom classes. These classes handle the logic associated with those events, making your code cleaner, modular, and easier to maintain.

[![Sponsor](https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=#white)](//github.com/sponsors/kettasoft)
[![Latest Stable Version](https://poser.pugx.org/santigarcor/booter/v?style=for-the-badge)](//packagist.org/packages/kettasoft/booter)
[![Total Downloads](https://poser.pugx.org/kettasoft/booter/downloads?style=for-the-badge)](//packagist.org/packages/kettasoft/booter)
[![License](https://poser.pugx.org/kettasoft/booter/license?style=for-the-badge)](//packagist.org/packages/kettasoft/booter)
[![tests](https://github.com/kettasoft/booter/workflows/tests/badge.svg)](https://github.com/kettasoft/booter/actions?query=workflows/tests)

## Features

- Automatically boot and trigger model events with custom logic.
- Organize event-specific logic into separate, reusable classes.
- Works with Laravel's built-in model events (`created`, `updated`, `deleted`, etc.).
- Easy-to-use HasBooter trait that handles event firing.

## Installation

1. - Install the package via Composer:

```dash
composer require kettasoft/booter
```

2. - Add the `HasBooter` trait to any model where you want to manage events.

3. - Define the `$events` array in the model to map events to the classes that will handle them.

## Usage

1. - Add the `HasBooter` Trait to Your Model

   - Use the `HasBooter` trait in your model to enable event handling:

```php
use Scaffolding\Booter\Traits\HasBooter;

class Post extends Model
{
    use HasBooter;

    /**
     * The event-to-class mappings.
     *
     * @var array
     */
    protected static $events = [
        'created' => [
            \App\Boot\AttachAuthorIdBoot::class,
        ],
        'updated' => [
            \App\Boot\LogChangesBoot::class,
        ],
    ];
}
```

2. - Create Event Handler Classes
     Create a class for each event that you want to handle. Each class should have a handle method where you define the logic to run when the event is triggered.

```php
namespace App\Boots;

use Scaffolding\Booter\Contracts\HasBooterContract;

class AttachAuthorIdBoot implements HasBooterContract
{
    /**
     * Handle the model event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function handle(\Illuminate\Database\Eloquent\Model $model)
    {
        // Custom logic for 'created' event
        $model->author_id = auth()->id();
        $model->save();
    }
}
```

The class defined in the event will be called automatically when the event occurs.

3. - Handle Multiple Events

You can define multiple events in the $events array for a single model. Each event can have one or more classes that will be triggered in sequence.

```php
protected static $events = [
    'created' => [
        \App\Boot\AttachAuthorIdBoot::class,
        \App\Boot\SendNotificationBoot::class,
    ],
    'updated' => [
        \App\Boot\LogChangesBoot::class,
    ],
];
```

4. - Event Handling Flow

   - When the model event (like `created`, `updated`, etc.) is triggered, the package automatically fires the associated class.
   - Each class must have a handle method where you implement the custom logic.

## Contributing

Contributions are welcome! If you find any issues or have ideas for improvements, feel free to submit a pull request or open an issue.

## License

This package is open-source software licensed under the MIT license.
