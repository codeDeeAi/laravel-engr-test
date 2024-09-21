<?php

declare(strict_types=1);

namespace App\Traits;

use App\Mail\OrderCreated;
use Illuminate\Support\Facades\Mail;

/**
 * Traits to for all single HMO emails
 *
 * @author Adeola Bada
 */
trait HmoEmails
{
    /**
     * Send an email notification for the order creation.
     *
     * This method sends an email to the user associated with the current instance,
     * notifying them that an order has been created. It uses the OrderCreated Mailable
     * class to construct the email and sends it to the user's email address.
     *
     * @param int $order_id The ID of the order that was created.
     *
     * @return \Illuminate\Mail\Mailable|\Illuminate\Support\Facades\Mail The result of the mail send operation.
     *
     * @throws \Throwable If the mail sending fails.
     */
    public function sendOrderCreatedMail(int $order_id)
    {
        return Mail::to($this)->send(
            (new OrderCreated($order_id))
        );
    }
}
