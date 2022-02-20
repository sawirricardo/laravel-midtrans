<?php

namespace Sawirricardo\Midtrans\Laravel;

use Sawirricardo\Midtrans\Dto\TransactionStatus;

class Notification
{
    private TransactionStatus $transactionStatus;
    private $callbackCreditCardChallenged;
    private $callbackCreditCardSuccess;
    private $callbackSettlement;
    private $callbackExpired;
    private $callbackPending;
    private $callbackCancelled;
    private $callbackDenied;

    public function __construct(TransactionStatus $transactionStatus)
    {
        $this->transactionStatus = $transactionStatus;
    }

    public static function make(TransactionStatus|array $transactionStatus)
    {
        if (is_array($transactionStatus)) {
            return new static(new TransactionStatus($transactionStatus));
        }
        return new static($transactionStatus);
    }

    /**
     * Set payment status in merchant's database to 'challenge'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenCreditCardChallenged(callable $callback): static
    {
        $this->callbackCreditCardChallenged = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'success'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenCreditCardSuccess(callable $callback): static
    {
        $this->callbackCreditCardSuccess = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'settlement'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenSettlement(callable $callback): static
    {
        $this->callbackSettlement = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'expired'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenPending(callable $callback): static
    {
        $this->callbackPending = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'denied'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenDenied(callable $callback): static
    {
        $this->callbackDenied = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'expired'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenExpired(callable $callback): static
    {
        $this->callbackExpired = $callback;
        return $this;
    }

    /**
     * Set payment status in merchant's database to 'denied'
     * @param callable $callback accepts \Sawirricardo\Midtrans\Dto\TransactionStatus
     */
    public function whenCancelled(callable $callback): static
    {
        $this->callbackCancelled = $callback;
        return $this;
    }

    public function listen()
    {
        if ($this->transactionStatus->transaction_status == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($this->transactionStatus->payment_type == 'credit_card') {
                if ($this->transactionStatus->fraud_status == 'challenge') {
                    if (is_callable($this->callbackCreditCardChallenged)) {
                        call_user_func($this->callbackCreditCardChallenged, $this->transactionStatus);
                    }
                } else {
                    if (is_callable($this->callbackCreditCardSuccess)) {
                        call_user_func($this->callbackCreditCardSuccess, $this->transactionStatus);
                    }
                }
            }
        } elseif ($this->transactionStatus->transaction_status == 'settlement') {
            if (is_callable($this->callbackSettlement)) {
                call_user_func($this->callbackSettlement, $this->transactionStatus);
            }
        } elseif ($this->transactionStatus->transaction_status == 'pending') {
            if (is_callable($this->callbackPending)) {
                call_user_func($this->callbackPending, $this->transactionStatus);
            }
        } elseif ($this->transactionStatus->transaction_status == 'deny') {
            if (is_callable($this->callbackDenied)) {
                call_user_func($this->callbackDenied, $this->transactionStatus);
            }
        } elseif ($this->transactionStatus->transaction_status == 'expire') {
            if (is_callable($this->callbackExpired)) {
                call_user_func($this->callbackExpired, $this->transactionStatus);
            }
        } elseif ($this->transactionStatus->transaction_status == 'cancel') {
            if (is_callable($this->callbackCancelled)) {
                call_user_func($this->callbackCancelled, $this->transactionStatus);
            }
        }
    }
}
