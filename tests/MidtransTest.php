<?php

use Sawirricardo\Midtrans\Midtrans;

it('can switch environment based on config is_production', function () {
    config()->set('midtrans.is_production', true);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.client_key') . '"></script>');
    config()->set('midtrans.is_production', false);
    expect(Midtrans::snapScripts())->toBe('<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>');
});

it('can generate a valid signature key', function () {
    $result = Midtrans::verifyNotification(json_decode(env('MIDTRANS_NOTIFICATION'), true));
    expect($result)->toBeTrue();
});
