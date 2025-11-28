<?php declare(strict_types=1);

namespace App\Services;

class AppConfiguration
{

    public const string VERSION_VARIABLE = 'GIT_TAG';

    /**
     * @param mixed[] $config
     */
    public function __construct(private array $config)
    {
    }


    public function getNaan(): int
    {
        return (int) $this->config['env']['NAAN'];
    }

}
