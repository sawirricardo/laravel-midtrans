<?php

namespace Sawirricardo\Midtrans\Laravel;

use Illuminate\Http\Client\PendingRequest;
use Sawirricardo\Midtrans\Dto\SnapTokenDto;
use Sawirricardo\Midtrans\Dto\TransactionDto;

class Snap
{
    private PendingRequest $http;

    public function __construct(PendingRequest $http)
    {
        $this->http = $http;
    }

    public function create(TransactionDto $transactionDto): SnapTokenDto
    {
        return new SnapTokenDto(
            $this->http->post('/transactions', $transactionDto->toArray())->json()
        );
    }
}
