<?php

namespace Sawirricardo\Midtrans;

trait SnakeCaseConverter
{
    public function convertArrayKeysToSnakeCase($array)
    {
        return array_map(
            function ($item) {
                if (is_array($item)) {
                    $item = $this->convertArrayKeysToSnakeCase($item);
                }

                return $item;
            },
            $this->doSnakeCase($array)
        );
    }

    private function doSnakeCase($input)
    {
        $result = [];

        foreach ($input as $key => $value) {
            $key = $this->snakeCase($key);

            $result[$key] = $value;
        }

        return $result;
    }

    private function snakeCase($input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }
}
