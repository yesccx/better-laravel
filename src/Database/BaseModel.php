<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database;

use Illuminate\Database\Eloquent\Model;
use Yesccx\BetterLaravel\Database\Traits\IdeHelpers;
use Yesccx\BetterLaravel\Database\Traits\SerializeDate;

/**
 * 模型基类
 */
abstract class BaseModel extends Model
{
    use SerializeDate, IdeHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];
}
