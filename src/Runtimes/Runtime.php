<?php

namespace Appwrite\Runtimes;

class Runtime
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Version[]
     */
    protected $versions = [];

    /**
     * @var string
     */
    protected $buildCommand = '';

    /**
     * Runtime that can contain different Versions.
     * 
     * @param string $key
     * @param string $name
     * @param string $buildCommand
     */
    public function __construct(string $key, string $name, string $buildCommand = '')
    {
        $this->key = $key;
        $this->name = $name;
        $this->buildCommand = $buildCommand;
        $this->versions;
    }

    /**
     * Get key.
     * 
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get build command
     * 
     * @return string 
    */
    public function getBuildCommand(): string
    {
        return $this->buildCommand;
    }

    /**
     * Adds new version to runtime.
     * 
     * @param string $version
     * @param string $base
     * @param string $image
     * @param string[] $supports
     */
    public function addVersion(string $version, string $base, string $image, array $supports): void
    {
        $this->versions[] = new Version($version, $base, $image, $supports);
    }

    /**
     * List runtime with all parsed Versions.
     * 
     * @return array[]
     */
    public function list(): array
    {
        $list = [];
        foreach ($this->versions as $version) {
            $key = "{$this->key}-{$version->version}";
            $list[$key] = array_merge(
                [
                    'name' => $this->name,
                    'logo' => "{$this->key}.png",
                ],
                $version->get()
            );
        }

        return $list;
    }
}