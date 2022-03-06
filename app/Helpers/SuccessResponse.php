<?php

namespace App\Helpers;

class SuccessResponse
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

    /**
     * Response data
     * @var mixed
     */
    public $data;

    public function __construct($data = false)
    {
        $this->is_error = false;
        $this->status   = config('app-config.RESPONSE.CODE.SUCCESS', 200);
        $this->message  = config('app-config.RESPONSE.MESSAGE.SUCCESS', 'Api executed successfully');
        $this->data     = $data ? $data : null;
    }
}
