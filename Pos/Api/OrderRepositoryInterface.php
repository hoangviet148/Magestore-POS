<?php

namespace Learning\Pos\Api;

interface OrderRepositoryInterface
{
    /**
     * @param mixed $orderData
     *
     * @return mixed
     */
    public function create($orderData);
}
