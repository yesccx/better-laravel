<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Validation\Traits;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

/**
 * 验证器场景
 */
trait ValidatorScenes
{
    /**
     * 当前验证场景
     *
     * @var string
     */
    protected string $currentScene = '';

    /**
     * 验证场景
     *
     * @return array
     */
    public function scenes(): array
    {
        return [];
    }

    /**
     * 指定当前验证场景
     *
     * @param string $currentScene
     *
     * @return self
     */
    public function useScene(string $currentScene): self
    {
        $this->currentScene = $currentScene;

        return $this;
    }

    /**
     * 配置验证实例
     *
     * @param Validator $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $scenes = match (true) {
            method_exists($this, 'scenes') => $this->container->call([$this, 'scenes']),
            default => []
        };

        if (empty($scenes)) {
            return;
        }

        // 解析出场景对应的待验证字段
        $currentScene = $this->parseScene();
        $sceneAttributes = $scenes[$currentScene] ?? null;
        if (is_null($sceneAttributes)) {
            return;
        }

        /** @var Validator $this */
        $rules = $this->container->call([$this, 'rules']);

        // 构建出场景对应的验证规则集
        $sceneRules = [];
        foreach ($sceneAttributes as $key => $value) {
            if (is_numeric($key) && !empty($ruleValue = $rules[$value] ?? null)) {
                $sceneRules[$value] = $ruleValue;
            } else {
                $sceneRules[$key] = $value;
            }
        }

        $validator->setRules($sceneRules);
    }

    /**
     * 解析出验证场景
     * 优先使用指定的验证场景，否则从上下文中获取actionName作为场景名
     *
     * @return string
     */
    protected function parseScene(): string
    {
        return $this->currentScene ?: Str::after(request()->route()->getActionName(), '@');
    }
}
