<?php

use Sawirricardo\Midtrans\Dto\TransactionDto;
use Sawirricardo\Midtrans\Laravel\Midtrans;

it('can switch environment based on config is_production', function () {
    config()->set('midtrans.is_production', true);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.client_key') . '"></script>');
    config()->set('midtrans.is_production', false);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>');
});

it('can create a transaction', function () {
    $token = midtrans()->snap()->create(new TransactionDto([
        'transaction_details' => [
            'order_id' => 'order-id-123',
            'gross_amount' => 10000,
        ],
    ]));
    expect($token->token)->not->toBeNull();
    expect($token->redirect_url)->not->toBeNull();
});
