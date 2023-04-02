<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

/**
 * 身份证号验证
 */
final class IdCardRule extends BaseRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (mb_strlen($value) != 15 && mb_strlen($value) != 18) {
            return false;
        }

        // 如果是 18 位，将最后一位校验码记为 $checksum
        if (mb_strlen($value) == 18) {
            $checksum = $value[17];
        }

        // 将身份证号码转换为数组
        $idcardArr = mb_str_split($value);

        // 如果是 15 位，则在末尾添加一个 0
        if (mb_strlen($value) == 15) {
            array_push($idcardArr, '0');
        }

        // 计算校验码
        $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2]; // 加权因子
        $verifyCodes = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2']; // 校验码对应值
        $checksumSum = 0;
        for ($i = 0; $i < 17; $i++) {
            $checksumSum += intval($idcardArr[$i]) * $factor[$i];
        }
        $checksumIndex = $checksumSum % 11;
        $checksumValue = $verifyCodes[$checksumIndex];

        // 判断校验码是否正确
        return match (mb_strlen($value)) {
            15      => $checksumValue == $idcardArr[15],
            default => $checksumValue == mb_strtoupper($checksum)
        };
    }
}
