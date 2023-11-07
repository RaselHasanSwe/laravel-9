<?php 

namespace App\Services;

use Exception;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;


class RedisStoreService implements RedisHelperInterface {

    private $emailStoredKey = "list_of_email";

    public function storeRecentMessage( mixed $id, string $messageSubject, string $toEmailAddress ): void
    {
        try {

            $data = [ 'id' => $id, 'message_subject' => $messageSubject, 'to_email_address'=> $toEmailAddress ];
            $savedData = [];
            if (Cache::has($this->emailStoredKey)) $savedData = Cache::get($this->emailStoredKey);
            array_push($savedData, $data);
            Cache::forever($this->emailStoredKey, $savedData);

        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());   
        }

    }

    public function getEmailList() : array 
    {
        try {
            $emails = Cache::has($this->emailStoredKey) ? array_reverse(Cache::get($this->emailStoredKey)) : [];
            return $emails;
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());   
        }
        
    }
}