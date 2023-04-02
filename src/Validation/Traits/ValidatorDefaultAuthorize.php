<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Validation\Traits;

/**
 * 验证器默认鉴权
 */
trait ValidatorDefaultAuthorize
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
