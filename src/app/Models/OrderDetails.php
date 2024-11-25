<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class OrderDetails extends Model
{
    protected ?string $table = 'order_details';
    private OrderSauce $orderSauceModel;
    private OrderExtras $orderExtrasModel;

    public function __construct(protected IConnection $connection, private int $order_id, private array $cart)
    {
        parent::__construct($connection);
    }

    public function placeOrderDetails(): self
    {
        foreach ($this->cart as $item) :
            $this->create([
                'order_id' => $this->order_id,
                'product_id' => $item['product']['id'],
                'quantity' => $item['quantity'],
                'price' => $item['product']['price'],
            ]);

            $order_details_id = $this->lastInsertId();
            #prd($item);
            if (isset($item['sauce']['id']) && $item['sauce']['id'] != 0) :
                $this->orderSauceModel = (new OrderSauce(
                    $this->connection,
                    $order_details_id,
                    $item['sauce']['id']
                ))->placeOrderSauce();
            endif;

            if (isset($item['extras']) && !empty($item['extras'])) :
                $this->orderExtrasModel = (new OrderExtras(
                    $this->connection,
                    $order_details_id,
                    $item['extras']
                ))->placeOrderExtras();
            endif;
        endforeach;
        return $this;
    }
}
