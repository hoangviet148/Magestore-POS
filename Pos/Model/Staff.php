<?php

namespace Learning\Pos\Model;

use Magento\Framework\Model\AbstractModel;
use Learning\Pos\Model\ResourceModel\Staff as ResourceModel;

class Staff extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getData('username');
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        return $this->setData('username', $username);
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->getData('password');
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        return $this->setData('password', $password);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * @inheritDoc
     */
    public function getTelephone()
    {
        return $this->getData('telephone');
    }

    /**
     * @inheritDoc
     */
    public function setTelephone($telephone)
    {
        return $this->setData('telephone', $telephone);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }
}
