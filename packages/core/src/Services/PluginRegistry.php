<?php

namespace ContentStash\Core\Services;

use ContentStash\Core\Plugin;
use Illuminate\Support\Collection;

class PluginRegistry
{
    /**
     * List of registered plugins.
     */
    protected Collection $plugins;

    public function __construct()
    {
        $this->plugins = collect();
    }

    /**
     * Register a new plugin.
     */
    public function register(array $attributes): Plugin
    {
        $plugin = new Plugin($attributes);

        if ($this->get($plugin->getName())) {
            throw new \Exception('Plugin with name '.$plugin->getName().' already exists.');
        }

        $this->plugins[$plugin->getName()] = $plugin;

        return $plugin;
    }

    /**
     * Get all registered plugins.
     */
    public function all(): Collection
    {
        return $this->plugins;
    }

    /**
     * Get all registered plugins as array.
     */
    public function allAsArray(): array
    {
        return $this->plugins->map(function (Plugin $plugin) {
            return $plugin->toArray();
        })->toArray();
    }

    /**
     * Get a plugin by name.
     */
    public function get(string $name): ?Plugin
    {
        return $this->plugins->get($name);
    }
}
