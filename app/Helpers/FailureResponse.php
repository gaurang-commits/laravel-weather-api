<?php

namespace App\Helpers;

class FailureResponse
{
    /**
     * Error property
     * @var int
     */
    public $is_error;

    /**
     * Status Code
     * @var int
     */
    public $status;

    /**
     * Message
     * @var string
     */
    public $message;


    public function __construct($message = false, $status=false)
    {
        $this->is_error = true;
        $this->status   = $status ? $status : config('app-config.RESPONSE.CODE.FAILURE', 400);
        $this->message  = $message ? $message : config('app-config.RESPONSE.MESSAGE.FAILURE', 'Some error occurred while executing the API');
    }
}
