<?php

namespace Sawirricardo\Midtrans\Laravel;

use Exception;
use Sawirricardo\Midtrans\Midtrans as BaseMidtrans;

class Midtrans extends BaseMidtrans
{
    public static function makeFromConfig($config)
    {
        return new static(
            $config['is_production'] ? $config['server_key'] : $config['sandbox_server_key'],
            $config['is_production'] ? $config['client_key'] : $config['sandbox_client_key'],
            $config['is_production'],
            $config['is_3ds'],
            $config['is_sanitized']
        );
    }

    public function new()
    {
        if (is_null($this->serverKey) || is_null($this->clientKey)) {
            throw new Exception('Server key or Client key is not set');
        }

        return $this;
    }


    public static function snapScripts(): string
    {
        if (config('midtrans.is_production', false)) {
            return '<script src="' . BaseMidtrans::SNAP_JS_PRODUCTION_URL . '" data-client-key="' . config('midtrans.client_key') . '"></script>';
        }

        return '<script src="' . BaseMidtrans::SNAP_JS_SANDBOX_URL . '" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>';
    }

    public static function cardScripts($scriptId = "midtrans-script"): string
    {
        return '<script type="text/javascript"
        src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        id="' . $scriptId . '"
        data-environment="' . (config('midtrans.is_production', false) ? 'production' : 'sandbox') . '"
        data-client-key="' . config('midtrans.is_production', false) ? config('midtrans.client_key') : config('midtrans.sandbox_client_key') . '"></script>';
    }
}
