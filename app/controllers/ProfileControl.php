<?php

use ECommerce\Order;
use Kareem3d\Membership\Account;

class ProfileController extends BaseController {

    /**
     * @param Account $accounts
     * @param Order $orders
     */
    public function __construct(Account $accounts, Order $orders)
    {
        $this->accounts = $accounts;
        $this->orders = $orders;
    }

    public function getPersonal()
    {
        // Get authenticated user
        $user = Auth::user();

        return array(
            ''
        );

    }

} 