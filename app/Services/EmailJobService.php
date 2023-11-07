<?php 

namespace App\Services;

use App\Jobs\SendMailJob;
use Exception;

class EmailJobService {

    public function dispatchEmailJob( string $messageBody, string $messageSubject, string $toEmailAddress) : void 
    {
        try {
            dispatch(
                new SendMailJob(
                    $messageBody,
                    $messageSubject,
                    $toEmailAddress
                )
            );
        } catch (\Exception $ex) {
            throw new Exception( $ex->getMessage(), $ex->getCode());
        }
    } 
}