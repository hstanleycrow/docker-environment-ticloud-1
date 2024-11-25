<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class OrderExtras extends Model
{
    protected ?string $table = 'order_extras';

    public function __construct(protected IConnection $connection, private int $order_details_id, private array $extras)
    {
        parent::__construct($connection);
    }

    public function placeOrderExtras(): self
    {

        foreach ($this->extras as $item) :
            $this->create([
                'order_details_id' => $this->order_details_id,
                'extra_id' => $item['id'],
            ]);
        endforeach;
        return $this;
    }
}
