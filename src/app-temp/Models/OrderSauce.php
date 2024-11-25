<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class OrderSauce extends Model
{
    protected ?string $table = 'order_sauce';

    public function __construct(protected IConnection $connection, private int $order_details_id, private int $sauce_id)
    {
        parent::__construct($connection);
    }

    public function placeOrderSauce(): self
    {

        #foreach ($this->cart as $item) :
        $this->create([
            'order_details_id' => $this->order_details_id,
            'sauce_id' => $this->sauce_id,
        ]);
        #endforeach;

        return $this;
    }
}
