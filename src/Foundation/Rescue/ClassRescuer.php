<?php

declare(strict_types = 1);

namespace Gupo\BetterLaravel\Foundation\Rescue;

final class ClassRescuer
{
    /**
     * @param mixed $resource
     * @param mixed $rescue
     * @param mixed $report
     *
     * @return void
     */
    public function __construct(
        protected mixed $resource,
        protected mixed $rescue = null,
        protected mixed $report = true
    ) {
    }

    /**
     * Dynamically pass method calls to the resource.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        try {
            return $this->resource->{$method}(...$parameters);
        } catch (\Throwable $e) {
            if (value($this->report, $e, $parameters)) {
                report($e);
            }

            return value($this->rescue, $e, $parameters);
        }
    }
}
