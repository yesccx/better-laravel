<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Validation\Traits;

use Illuminate\Support\Arr;

trait ValidatorFetchValidated
{
    /**
     * 仅获取已验证过的数据，将对获取的数据做类型
     *
     * @param array $attributes
     * @return array
     */
    public function fetchValidated(array $attributes): array
    {
        $validated = $this->validated();

        return Arr::only($this->fetchMany($attributes, $validated), array_keys($validated));
    }
}
