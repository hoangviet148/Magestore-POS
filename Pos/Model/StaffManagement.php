<?php

namespace Learning\Pos\Model;

use Exception;
use Learning\Pos\Api\StaffManagementInterface;
use Learning\Pos\Model\ResourceModel\Staff\CollectionFactory as StaffCollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Stdlib\CookieManagerInterface;

class StaffManagement implements StaffManagementInterface
{
    /**
     * @var CookieManagerInterface CookieManagerInterface
     */
    private $cookieManager;
    protected $collectionFactory;

    public function __construct(
        CookieManagerInterface $cookieManager,
        StaffCollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->cookieManager = $cookieManager;
    }

    public function authenticate($username, $password)
    {
        try {
            $test = new DataObject();
            $staff = $this->collectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter("username", ["eq" => $username])
                ->getFirstItem();

            $staffId = (int)$staff->getId();
            if (!$staffId) {
                $message = [
                    "code" => "201",
                    "message" => "This account isn't confirmed. Verify and try again.",
                    "status" => false
                ];
                return $test->addData($message);
            } else if ((int)$staff->getData("status") === 0) {
                $message = [
                    "code" => "401",
                    "message" => "This account isn't active. Please connect to admin of website",
                    "status" => false
                ];
                return $test->addData($message);
            } else if ($staff->getData("password") !== $password) {
                $message = [
                    "code" => "401",
                    "message" => "Password not correct. Please connect to admin of website",
                    "status" => false
                ];
                return $test->addData($message);
            }
            $cookie = $this->cookieManager->getCookie('PHPSESSID');
            $test->addData(["status" => true, "username" => $staff->getData('username'), "email" => $staff->getData('email')]);
            return $test;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
