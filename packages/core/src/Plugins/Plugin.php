<?php

namespace ContentStash\Core\Plugins;

class Plugin
{
    /**
     * The name of the plugin.
     */
    protected string $name;

    /**
     * The path of the plugin.
     */
    protected string $path;

    /**
     * The local path of the plugin.
     */
    protected string $localPath;

    /**
     * List of additional attributes
     */
    protected array $additionalAttributes = [];

    /**
     * List of required attributes
     */
    protected static array $requiredAttributes = [
        'name',
        'path',
    ];

    /**
     * Create a new instance of the plugin.
     */
    public function __construct(array $attributes)
    {
        // check if $required attributes are set
        if ($missing = array_diff(self::$requiredAttributes, array_keys($attributes))) {
            dd([
                'message' => 'Missing required attributes for contentstash plugin '.($attributes['name'] ?? 'unknown'),
                'missing' => $missing,
            ]);
        }

        $this->name = $attributes['name'];
        $this->path = $attributes['path'];
        $this->localPath = $attributes['local_path'] ?? $attributes['path'].'resources/ts/locales/';
        $this->additionalAttributes = array_diff_key($attributes, array_flip(array_merge(self::$requiredAttributes, ['local_path'])));
    }

    /**
     * Get the name of the plugin.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the path of the plugin.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the local path of the plugin.
     */
    public function getLocalPath(): string
    {
        return $this->localPath;
    }

    /**
     * Get the additional attributes of the plugin.
     */
    public function getAdditionalAttributes(): array
    {
        return $this->additionalAttributes;
    }
}
