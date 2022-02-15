<?php

namespace Sawirricardo\Midtrans;

class Snap
{
    use SnakeCaseConverter;

    /** @var TransactionDetail */
    public $transactionDetail;

    /** @var CustomerDetail */
    public $customerDetail;

    /** @var ItemDetail[] */
    public $itemDetails;

    public $callbacks;
    public $expiry;

    public function __construct(
        ?TransactionDetail $transactionDetail = null,
        ?CustomerDetail $customerDetail = null,
        ?array $itemDetails = null,
    ) {
        $this->transactionDetail = $transactionDetail;
        $this->customerDetail = $customerDetail;
        $this->itemDetails = $itemDetails;
    }

    public function setTransactionDetail(TransactionDetail $transactionDetail)
    {
        $this->transactionDetail = $transactionDetail;

        return $this;
    }

    public static function make(
        ?TransactionDetail $transactionDetail,
        ?CustomerDetail $customerDetail,
        ?array $itemDetails,
    ): Snap {
        return new static($transactionDetail, $customerDetail, $itemDetails);
    }

    public function create()
    {
        $params = [];
        if ($this->transactionDetail) {
            $params['transaction_details'] = $this->convertArrayKeysToSnakeCase(json_decode(json_encode($this->transactionDetail), true));
        }
        if ($this->customerDetail) {
            $params['customer_details'] = $this->convertArrayKeysToSnakeCase(json_decode(json_encode($this->customerDetail), true));
        }
        if ($this->itemDetails) {
            $params['item_details'] = $this->convertArrayKeysToSnakeCase(json_decode(json_encode($this->itemDetails), true));
        }
        if ($this->callbacks) {
            $params['callbacks'] = $this->callbacks;
        }
        if ($this->expiry) {
            $params['expiry'] = $this->expiry;
        }

        try {
            $client = new \GuzzleHttp\Client();
            dump($params);
            dump(config('midtrans.sandbox_server_key'));
            $response = $client->post(config('midtrans.is_production') ? Midtrans::SNAP_PRODUCTION_BASE_URL : Midtrans::SNAP_SANDBOX_BASE_URL . '/transactions', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(config('midtrans.is_production') ? config('midtrans.server_key') : config('midtrans.sandbox_server_key') . ':'),
                ],
                'json' => $params,
            ]);
            $result = json_decode($response->getBody(), true);

            return new SnapTransaction($result['redirect_url'], $result['token']);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dump($e->getCode());
            dump(json_decode($e->getResponse()->getBody()->getContents(), true));
            echo \GuzzleHttp\Psr7\Message::toString($e->getRequest());
            echo \GuzzleHttp\Psr7\Message::toString($e->getResponse());
        }
    }

    public function setCustomerDetail(CustomerDetail $customerDetail)
    {
        $this->customerDetail = $customerDetail;

        return $this;
    }

    public function addItemDetail(ItemDetail $itemDetail)
    {
        $this->itemDetails[] = $itemDetail;

        return $this;
    }

    public function addItemDetailIf(bool $condition, ItemDetail $itemDetail)
    {
        if ($condition) {
            $this->addItemDetail($itemDetail);
        }

        return $this;
    }

    public function whenFinishRedirectTo(string|callable $url)
    {
        if (is_callable($url)) {
            dump($url);
            dump(call_user_func($url));
            $this->callbacks['finish'] = call_user_func($url);
        } else {
            $this->callbacks['finish'] = $url;
        }

        return $this;
    }

    public function whenUnfinishRedirectTo(string|callable $url)
    {
        if (is_callable($url)) {
            $this->callbacks['unfinish'] = call_user_func($url);
        } else {
            $this->callbacks['unfinish'] = $url;
        }

        return $this;
    }

    public function whenErrorRedirectTo(string|callable $url)
    {
        if (is_callable($url)) {
            $this->callbacks['error'] = call_user_func($url);
        } else {
            $this->callbacks['error'] = $url;
        }

        return $this;
    }

    /**
     * set Expiry time for payment page
     *
     * @param string $unit unit of time, can be `minute`, `hour`, `day`
     * @param int $duration
     * @param string $startTime yyyy-MM-dd HH:mm:ss Z
     * @return void
     */
    public function withExpiry($unit = 'minute', $duration = 1, $startTime = null)
    {
        $this->expiry['start_time'] = $startTime;
        $this->expiry['unit'] = $unit;
        $this->expiry['duration'] = $duration;
    }
}
