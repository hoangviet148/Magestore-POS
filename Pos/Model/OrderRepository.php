<?php

namespace Learning\Pos\Model;

use Magento\Catalog\Model\Product;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Model\Service\OrderService;
use Magento\Store\Model\StoreManagerInterface;
use Learning\Pos\Api\OrderRepositoryInterface;

class OrderRepository extends AbstractHelper implements OrderRepositoryInterface
{
    /**
     * @var Product|Magento\Catalog\Model\Product
     */
    private $_product;
    /**
     * @var StoreManagerInterface|Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;
    /**
     * @var CustomerFactory|Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;
    /**
     * @var QuoteFactory|Magento\Quote\Model\Quote
     */
    private $quote;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var QuoteManagement
     */
    private $quoteManagement;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Product $product
     * @param FormKey $formkey
     * @param QuoteFactory $quote ,
     * @param QuoteManagement $quoteManagement
     * @param CustomerFactory $customerFactory ,
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderService $orderService ,
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Product $product,
        FormKey $formkey,
        QuoteFactory $quote,
        QuoteManagement $quoteManagement,
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        OrderService $orderService
    )
    {
        $this->_storeManager = $storeManager;
        $this->_product = $product;
        $this->_formkey = $formkey;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        parent::__construct($context);
    }

    public function create($orderData)
    {
        $store = $this->_storeManager->getStore();
        var_dump($orderData['items']);
        die();
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($orderData['email']);
        if (!$customer->getEntityId()) {
            //If not avilable then create this customer
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($orderData['shipping_address']['firstname'])
                ->setLastname($orderData['shipping_address']['lastname'])
                ->setEmail($orderData['email'])
                ->setPassword($orderData['email']);
            $customer->save();
        }
        $quote = $this->quote->create(); //Create object of quote
        $quote->setStore($store); //set store for which you create quote

        // if you have allready buyer id then you can load customer directly
        $customer = $this->customerRepository->getById($customer->getEntityId());
        $quote->setCurrency();
        $quote->assignCustomer($customer); //Assign quote to customer

        //add items in quote
        foreach ($orderData['items'] as $item) {
            $product = $this->_product->load($item['product_id']);

            $product->setPrice($product->getPrice());
            $quote->addProduct(
                $product,
                intval($item['qty'])
            );

        }

        //Set Address to quote
        $quote->getBillingAddress()->addData($orderData['shipping_address']);
        $quote->getShippingAddress()->addData($orderData['shipping_address']);

        // Collect Rates and Set Shipping & Payment Method
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('flatrate_flatrate'); //shipping method
        $quote->setPaymentMethod('checkmo'); //payment method
        $quote->setInventoryProcessed(false); //not effetc inventory
        $quote->save(); //Now Save quote and your quote is ready

        // Set Sales Order Payment
        $quote->getPayment()->importData(['method' => 'checkmo']);

        // Collect Totals & Save Quote
        $quote->collectTotals()->save();

        // Create Order From Quote
        $order = $this->quoteManagement->submit($quote);

        $order->setEmailSent(0);
        $increment_id = $order->getRealOrderId();
        if ($order->getEntityId()) {
            $result['order_id'] = $increment_id;
        } else {
            $result = ['error' => 1, 'msg' => 'Your custom message'];
        }
        return $result;
    }
}
