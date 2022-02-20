<?php

namespace Sawirricardo\Midtrans\Laravel;

use Illuminate\Support\Facades\Http;
use Sawirricardo\Midtrans\Laravel\Snap;

class Midtrans
{
    private string $serverKey;
    private string $clientKey;
    private bool $isProduction;
    private bool $is3ds;
    private bool $isSanitized;

    public function __construct(
        string $serverKey,
        string $clientKey,
        bool $isProduction = false,
        bool  $is3ds = false,
        bool  $isSanitized = false
    ) {
        $this->serverKey = $serverKey;
        $this->clientKey = $clientKey;
        $this->isProduction = $isProduction;
        $this->is3ds = $is3ds;
        $this->isSanitized = $isSanitized;
    }

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
        return $this;
    }

    public function snap()
    {
        return new Snap($this->createHttpFactory(
            $this->isProduction
                ? 'https://app.midtrans.com/snap/v1'
                : 'https://app.sandbox.midtrans.com/snap/v1'
        ));
    }

    public function payment()
    {
        return new Payment($this->createHttpFactory(
            $this->isProduction
                ? 'https://api.midtrans.com'
                : 'https://api.sandbox.midtrans.com'
        ));
    }

    private function createHttpFactory(string $baseUrl)
    {
        return Http::acceptJson()->asJson()
            ->withToken(base64_encode($this->serverKey . ':'), 'Basic')
            ->baseUrl($baseUrl);
    }

    public static function snapScripts(): string
    {
        if (config('midtrans.is_production', false)) {
            return '<script src="' . \Sawirricardo\Midtrans\Midtrans::SNAP_JS_PRODUCTION_URL . '" data-client-key="' . config('midtrans.client_key') . '"></script>';
        }

        return '<script src="' . \Sawirricardo\Midtrans\Midtrans::SNAP_JS_SANDBOX_URL . '" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>';
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
