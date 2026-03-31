<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    /**
     * একটি নতুন order ও তার items তৈরি করবে
     *
     * @param array $orderData
     * @param array $itemsData
     * @return \App\Models\OrderManage
     */
    public function createOrder(array $orderData, array $itemsData);
    public function getUserOrders($userId);

    
    
}