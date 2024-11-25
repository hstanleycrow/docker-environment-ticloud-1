<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Order extends Model
{
    protected ?string $table = 'orders';
    const ORDER_STATUS_RECEIVED = 1;


    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function placeOrder(array $cart, array $paymentMethods, array $customerWithContactsData, string $notes): int
    {
        $this->create([
            'user_id' => $_SESSION['userdat']['id'],
            'branch_id' => $_SESSION['branch']['branch_id'],
            'customer_id' => $customerWithContactsData['id'],
            'customer_name' => $customerWithContactsData['name'],
            'customer_phone_number' => $customerWithContactsData['phone_number'],
            'delivery_address' => $customerWithContactsData['address'],
            'delivery_reference_point' => $customerWithContactsData['reference_point'],
            'order_status_id' => self::ORDER_STATUS_RECEIVED,
            'total_amount' => $this->calculateTotalAmount($cart),
            'payment_method_id' => $paymentMethods[0]['id'],
            'notes' => $notes,
        ]);
        return $this->lastInsertId();
    }


    private function calculateTotalAmount(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) :
            #prd($item);
            $total += $item['product']['price'] * $item['quantity'];
        endforeach;
        return $total;
    }
}
