<?php

namespace App\Controllers\OrdersControllers;

use Models\Order;
use Models\OrderSauce;
use Models\OrderExtras;
use Models\OrderDetails;
use App\Controllers\Controller;

class ProcessOrderController extends Controller
{

    private Order $orderModel;
    private OrderDetails $orderDetailsModel;
    private OrderSauce $orderSauceModel;
    private OrderExtras $orderExtrasModel;

    public function processOrder(): void
    {
        try {

            $cart = $_POST['cart'];
            $paymentMethods = $_POST['paymentMethods'];
            $customerWithContactsData = $_POST['customerWithContactsData'];
            $notes = $_POST['notes'];

            $this->orderModel = new Order($this->connection);

            $this->orderModel->beginTransaction();

            $this->orderModel->placeOrder($cart, $paymentMethods, $customerWithContactsData, $notes);
            $order_id = $this->orderModel->lastInsertId();

            $this->orderDetailsModel = (new OrderDetails(
                $this->connection,
                $order_id,
                $cart
            ))->placeOrderDetails();

            // Confirma la transacción
            $this->orderModel->commit();

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Revierte la transacción
            $this->orderModel->rollback();

            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
