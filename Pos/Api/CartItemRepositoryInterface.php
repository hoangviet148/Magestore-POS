<?php

namespace Learning\Pos\Api;

interface CartItemRepositoryInterface
{
    /**
     * @param string $sku
     * @return  \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getImage($sku);
}

