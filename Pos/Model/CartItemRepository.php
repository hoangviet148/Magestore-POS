<?php

namespace Learning\Pos\Model;

use Learning\Pos\Api\CartItemRepositoryInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

class CartItemRepository extends Template implements CartItemRepositoryInterface
{
    private $productRepository;

    public function __construct(
        Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    )
    {
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getImage($sku)
    {
        $url = null;
        $productimages = $this->productRepository->get($sku)->getMediaGalleryImages();
        foreach ($productimages as $productimage) {
            $url = $productimage['url'];
            break;
        }
        return $url;
    }
}
