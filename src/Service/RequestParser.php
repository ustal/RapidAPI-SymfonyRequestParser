<?php

/**
 * Created by PhpStorm.
 * User: George Cherenkov
 * Date: 30.05.17
 * Time: 15:17
 */

namespace RapidAPI\Service;

use RapidAPI\Exception\PackageException;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestParser
{
    public function getParamsFromRequest(RequestStack $requestStack): array
    {
        $request = $requestStack->getMasterRequest();
        $jsonContent = $request->getContent();
        if (empty($jsonContent)) {
            $result = $request->request->all();
        } else {
            $data = $this->normalizeJson($jsonContent);
            $data = str_replace('\"', '"', $data);
            $result = json_decode($data, true);
            if (json_last_error() != 0) {
                throw new PackageException(json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.');
            }
        }

        return $result;
    }

    private function normalizeJson($data)
    {
        return preg_replace_callback('~"([\[{].*?[}\]])"~s', function ($match) {
            return preg_replace('~\s*"\s*~', "\"", $match[1]);
        }, $data);
    }
}
