<?php

namespace App\Helpers;

use Carbon\Carbon;

class ApplicationHelper
{
    /**
     * Generate success response
     * 
     * @param $data
     */
    public function successResponse($data = false)
    {
        return new SuccessResponse($data);
        //response()->json(new SuccessResponse($data));
    }

    /**
     * Generate failure response
     * 
     * @param $message
     * @param $status
     */
    public function failureResponse($message = false, $status = false)
    {
        return new FailureResponse($message, $status);
    }

    public function convertToDateString($date)
    {
        return Carbon::createFromTimestamp($date)->toDateString();
    }
}