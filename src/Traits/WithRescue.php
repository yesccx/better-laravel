<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Traits;

use Yesccx\BetterLaravel\Foundation\Rescue\ClassRescuer;

/**
 * @property static $rescue Rescue Proxy
 */
trait WithRescue
{
    /**
     * The rescue proxy instance.
     *
     * @var ClassRescuer
     */
    protected ClassRescuer $_rescueProxy;

    /**
     * @param mixed $rescue
     * @param mixed $report
     *
     * @return static
     */
    public function withRescue(mixed $rescue = null, mixed $report = true)
    {
        return $this->_rescueProxy ??= new ClassRescuer($this, $rescue, $report);
    }

    /**
     * @param mixed $rescue
     * @param mixed $report
     *
     * @return static
     */
    public function __invoke(mixed $rescue = null, mixed $report = true)
    {
        return $this->withRescue($rescue, $report);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return match ($name) {
            'rescue' => $this->withRescue(),
            default  => null
        };
    }
}
