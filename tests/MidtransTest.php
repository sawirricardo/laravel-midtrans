<?php

use Sawirricardo\Midtrans\BillingAddress;
use Sawirricardo\Midtrans\CustomerDetail;
use Sawirricardo\Midtrans\ItemDetail;
use Sawirricardo\Midtrans\Midtrans;
use Sawirricardo\Midtrans\ShippingAddress;
use Sawirricardo\Midtrans\TransactionDetail;

it('can switch environment based on config is_production', function () {
    config()->set('midtrans.is_production', true);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.client_key') . '"></script>');
    config()->set('midtrans.is_production', false);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>');
});

it('can generate a valid signature key', function () {
    $result =  Midtrans::make()->verifyNotification(json_decode('{
        "transaction_time": "2020-01-09 18:27:19",
        "transaction_status": "capture",
        "transaction_id": "57d5293c-e65f-4a29-95e4-5959c3fa335b",
        "status_message": "midtrans payment notification",
        "status_code": "200",
        "signature_key": "",
        "payment_type": "credit_card",
        "order_id": "Postman-1578568851",
        "merchant_id": "M004123",
        "masked_card": "481111-1114",
        "gross_amount": "10000.00",
        "fraud_status": "accept",
        "eci": "05",
        "currency": "IDR",
        "channel_response_message": "Approved",
        "channel_response_code": "00",
        "card_type": "credit",
        "bank": "bni",
        "approval_code": "1578569243927"
      }', true));
    expect($result)->toBeTrue();
});

it('can create a transaction', function () {
    $transaction = Midtrans::snap()
        ->setTransactionDetail(new TransactionDetail('Postman-15785687', 5000))
        ->addItemDetail(ItemDetail::make()->setName('Item 1')->setPrice(1250)->setQuantity(2)->setId(1))
        ->addItemDetail(ItemDetail::make()->setName('Item 2')->setPrice(1250)->setQuantity(2)->setId(2))
        ->setCustomerDetail(
            CustomerDetail::make()
                ->setBillingAddress(
                    BillingAddress::make()
                        ->setFirstName('Rico')
                        ->setCountryCode('IDN')
                        ->setCity('Jakarta')
                )
                ->setShippingAddress(
                    ShippingAddress::make()
                        ->setFirstName('Rico')
                        ->setCountryCode('IDN')
                        ->setCity('Jakarta')
                )
        )
        ->whenFinishRedirectTo(function () {
            return 'https://kantongsayur.net/';
        })
        ->create();
    dump($transaction);
    expect($transaction->token)->not->toBeNull();
    expect($transaction->redirectUrl)->not->toBeNull();
});
