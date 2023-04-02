<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Traits;

/**
 * 初始化trait
 * PS: 赋予trait初始化能力
 */
trait InitializeTraits
{
    /**
     * @var array
     */
    protected static array $traitInitializers = [];

    public function __construct()
    {
        $this->initializeTraits();
    }

    /**
     * 初始化trait
     *
     * 收集类中所有trait初始化方法，进行初始化
     *
     * @return void
     */
    public function initializeTraits(): void
    {
        $class = static::class;

        if (empty(static::$traitInitializers)) {
            foreach (class_uses_recursive($class) as $trait) {
                if ($trait == __TRAIT__) {
                    continue;
                }

                if (method_exists($class, $method = 'initialize' . class_basename($trait))) {
                    static::$traitInitializers[] = $method;
                }
            }

            static::$traitInitializers = array_unique(static::$traitInitializers);
        }

        foreach (static::$traitInitializers as $method) {
            $this->{$method}();
        }
    }
}
