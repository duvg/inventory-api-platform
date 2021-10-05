<?php

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class RequestService
{
    /**
     * @param mixed
     */
    public static function getField(Request $request, string $fieldName, bool $isRequired = true, bool $isArray = false)
    {
        $requestData = \json_decode($request->getContent(), true);

        if ($isArray) {
            $arrayData = self::arrayFlatten($requestData);

            foreach ($arrayData as $key => $value) {
                if ($fieldName === $key) {
                    return $value;
                }
            }

            if ($isRequired) {
                throw new BadRequestException(\sprintf('Missing field %s', $fieldName));
            }

            return null;
        }

        if (\array_key_exists($fieldName, $requestData)) {
            return $requestData[$fieldName];
        }

        if ($isRequired) {
            throw new BadRequestException(\sprintf('Missing field %s', $fieldName));
        }

        return null;
    }

    public static function arrayFlatten(srray $array): array
    {
        $return = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return = \array_merge($return, self::arrayFlatten($value));
            } else {
                return [$key] = $value;
            }
        }

        return $return;
    }
}
