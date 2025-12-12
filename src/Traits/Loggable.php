<?php

namespace MichaelOrenda\Logging\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MichaelOrenda\Logging\Facades\Logger;
use Illuminate\Support\Facades\Log;

/**
 * Trait Loggable
 *
 * Attach to any Eloquent model to automatically emit activity logs
 * on create, update and delete (configurable).
 *
 * Usage:
 *   use MichaelOrenda\Logging\Traits\Loggable;
 *
 * Optional on model:
 *   protected static $loggableEvents = ['created','updated','deleted'];
 *   protected $loggableContext = ['some' => 'context'];
 */
trait Loggable
{
    /**
     * Boot the trait: register model event listeners.
     */
     protected static function bootLoggable(): void
    {
        foreach (static::getLoggableEvents() as $event) {

            // Fully-qualified Model type — avoids namespace resolution issues
            static::$event(function (\Illuminate\Database\Eloquent\Model $model) use ($event) {
                $model->writeLoggableEvent($event);
            });
        }
    }

    /**
     * Events to log. Models may override with:
     *
     *   protected static $loggableEvents = ['created','updated','deleted'];
     */
    protected static function getLoggableEvents(): array
    {
        if (property_exists(static::class, 'loggableEvents')) {
            return (array) static::$loggableEvents;
        }

        return ['created', 'updated', 'deleted'];
    }

    /**
     * Actually write the log.
     */
    protected function writeLoggableEvent(string $event): void
    {
        $context = [
            'model' => class_basename(static::class),
            'id'    => $this->getKey(),
        ];

        if ($event === 'updated') {
            $context['changes'] = $this->getDirty();
        }

        Logger::activity(
            strtolower(class_basename(static::class)) . "_{$event}",
            $context
        );
    }

    /**
     * Record a model-based log using the Logger facade.
     *
     * @param string $event
     * @return void
     */
    protected function recordModelLog(string $event): void
    {
        try {
            $payload = $this->buildModelLogContext($event);

            // Allow model to customize the event name
            $eventName = $this->getModelLogEventName($event);

            // Pick channel; default to activity
            $channel = $this->getModelLogChannel($event);

            // Use facade to write the log. Use dynamic call so Logger::activity(...) etc.
            if (method_exists(Logger::class, $channel) || method_exists(app('logger.manager'), $channel)) {
                // call as Logger::activity('event', $payload)
                \MichaelOrenda\Logging\Facades\Logger::__callStatic($channel, [$eventName, $payload]);
            } else {
                // fallback to activity
                Logger::activity($eventName, $payload);
            }
        } catch (\Throwable $e) {
            // Never throw from a model observer — swallow but write to Laravel log
            Log::error('Loggable trait failed: ' . $e->getMessage(), [
                'model' => static::class,
                'event' => $event,
            ]);
        }
    }

    /**
     * Build the context/payload for the model log.
     * Models can override getLoggableContext() to provide additional data.
     *
     * @param string $event
     * @return array
     */
    protected function buildModelLogContext(string $event): array
    {
        $base = [
            'model' => class_basename($this),
            'model_type' => get_class($this),
            'id' => $this->getKey(),
            'attributes' => $this->getAttributesForLog($event),
        ];

        // Merge any static or instance context defined on model
        $extra = [];
        if (property_exists($this, 'loggableContext')) {
            $extra = (array) $this->loggableContext;
        } elseif (method_exists($this, 'getLoggableContext')) {
            $extra = (array) $this->getLoggableContext($event);
        }

        return array_merge($base, $extra);
    }

    /**
     * Models may override how attributes are captured.
     * By default capture changed attributes on update, all attributes on create.
     *
     * @param string $event
     * @return array
     */
    protected function getAttributesForLog(string $event): array
    {
        if ($event === 'updated') {
            // Return only changed attributes and their new values
            return $this->getDirty();
        }

        // For created/deleted, return the current attributes (deleted will still have attributes)
        return $this->getAttributes();
    }

    /**
     * Determine the log event name. Models may override this behavior by defining:
     *   protected static $loggableName = 'user';
     * or implementing getModelLogEventName($event)
     *
     * @param string $event
     * @return string
     */
    protected function getModelLogEventName(string $event): string
    {
        if (method_exists($this, 'getCustomModelLogEventName')) {
            return (string) $this->getCustomModelLogEventName($event);
        }

        if (property_exists($this, 'loggableName') && $this->loggableName) {
            return $this->loggableName . '.' . $event;
        }

        // default: snake-case modelName.event e.g. user.created
        return Str::snake(class_basename($this)) . '.' . $event;
    }

    /**
     * Pick channel for model events. Models can override by providing getModelLogChannel().
     * Defaults:
     *  - created/updated/deleted -> activity
     *
     * @param string $event
     * @return string
     */
    protected function getModelLogChannel(string $event): string
    {
        if (method_exists($this, 'getModelLogChannel')) {
            return (string) $this->getModelLogChannel($event);
        }

        return 'activity';
    }
}
