<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Http;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Yesccx\BetterLaravel\Http\Traits\HttpResponse;

/**
 * 控制器基类
 */
abstract class BaseController extends Controller
{
    use ValidatesRequests, HttpResponse;
}
