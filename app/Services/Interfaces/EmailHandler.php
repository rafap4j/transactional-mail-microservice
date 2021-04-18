<?php

namespace App\Services\Interfaces;

/**
 * E-mail handler interface. This interface defines the contract
 * for classes that implement the e-mail sending functionalities.
 *
 * @package App\Services\Interfaces
 */
interface EmailHandler
{
    /**
     * Send the e-mail message.
     *
     * @param  array  $data
     * @return void
     */
    public function send(array $data);

    /**
     * Log the action performed.
     *
     * @param  array  $data
     * @return void
     */
    public function log(array $data);
}
