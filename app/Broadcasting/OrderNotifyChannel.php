<?php

namespace App\Broadcasting;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class OrderNotifyChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {

        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
