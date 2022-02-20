<?php

namespace Sawirricardo\Midtrans\Laravel;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Sawirricardo\Midtrans\Dto\TransactionDto;
use Sawirricardo\Midtrans\Dto\TransactionStatus;

class Payment
{
    private PendingRequest $http;

    public function __construct(PendingRequest $http)
    {
        $this->http = $http;
    }

    public function status(string $orderIdOrTransactionId): TransactionStatus
    {
        return new TransactionStatus(
            $this->http->get("/v2/{$orderIdOrTransactionId}/status")->collect()->toArray()
        );
    }

    public function charge(TransactionDto $transactionDto): Response
    {
        return $this->http->post('/v2/charge')
            ->json($transactionDto->toArray());
    }
}
