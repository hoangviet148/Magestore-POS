<?php

namespace Learning\Pos\Api;

use Exception;
use Learning\Pos\Api\Data\StaffInterface;

interface StaffManagementInterface
{
    /**
     * Constant for confirmation status
     */
    const ACCOUNT_CONFIRMED = 'account_confirmed';
    const ACCOUNT_CONFIRMATION_REQUIRED = 'account_confirmation_required';
    const ACCOUNT_CONFIRMATION_NOT_REQUIRED = 'account_confirmation_not_required';
    const MAX_PASSWORD_LENGTH = 256;

    /**
     * Authenticate a customer by username and password
     *
     * @param string $username
     * @param string $password
     * @return StaffInterface
     * @throws Exception
     */
    public function authenticate($username, $password);
}
