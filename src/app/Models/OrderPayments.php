<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class OrderPayments extends Model
{
    protected ?string $table = 'order_payments';

    public function __construct(protected IConnection $connection, private int $order_id, private array $paymentMethods)
    {
        parent::__construct($connection);
    }

    public function placeOrderPayments(): self
    {
        foreach ($this->paymentMethods as $paymentMethod) :
            $this->create([
                'order_id' => $this->order_id,
                'payment_method_id' => $paymentMethod['id'],
                'amount' => $paymentMethod['amount'],
            ]);
        endforeach;
        return $this;
    }
}
