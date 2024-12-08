<?php

namespace ContentStash\Core\Services;

use ContentStash\Core\Plugins\Plugin;

class PluginRegistry
{
    /**
     * List of registered plugins.
     */
    protected array $plugins = [];

    /**
     * Register a new plugin.
     */
    public function register(array $attributes): Plugin
    {
        $plugin = new Plugin($attributes);

        if ($this->findByName($plugin->getName())) {
            throw new \Exception('Plugin with name '.$plugin->getName().' already exists.');
        }

        $this->plugins[] = $plugin;

        return $plugin;
    }

    /**
     * Get all registered plugins.
     */
    public function all(): array
    {
        return $this->plugins;
    }

    /**
     * Find a plugin by name.
     */
    public function findByName(string $name): ?Plugin
    {
        foreach ($this->plugins as $plugin) {
            if ($plugin->getName() === $name) {
                return $plugin;
            }
        }

        return null;
    }
}
