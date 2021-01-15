<?php

namespace Learning\Pos\Api\Data;

interface StaffInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const NAME = 'name';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const EMAIL = 'email';
    const TELEPHONE = 'telephone';
    const STATUS = 'status';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     *
     * @return string|null
     */
    public function getUsername();

    /**
     * Set class
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username);

    /**
     *
     * @return string|null
     */
    public function getPassword();

    /**
     * Set university
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password);

    /**
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set university
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set university
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     *
     * @return boolean|null
     */
    public function getStatus();

    /**
     * Set university
     *
     * @param boolean $status
     * @return $this
     */
    public function setStatus($status);
}
