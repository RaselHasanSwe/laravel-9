<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\User;
use App\Services\EmailJobService;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Str;


class EmailController extends BaseController
{

    protected $elasticsearchHelper;
    protected $redisHelper;
    protected $jobDispatchService;

    public function __construct( 
        ElasticsearchHelperInterface $elasticsearchHelper, 
        RedisHelperInterface $redisHelper,  
        EmailJobService $jobDispatchService
    )
    {
        $this->elasticsearchHelper = $elasticsearchHelper;
        $this->redisHelper = $redisHelper;
        $this->jobDispatchService = $jobDispatchService;
    }

    // TODO: finish implementing send method
    public function send(User $user, EmailRequest $request)
    {
        if(request()->user()->email !== $user->email)
            return $this->sendError('Unauthorised.', ['error'=>'Api token does not belongs to current user'], 401); 

        $elasticsearchSavedId = [];

        try {
            foreach($request->emails as $email){

                $this->jobDispatchService->dispatchEmailJob(
                    $email['message_body'], 
                    $email['message_subject'], 
                    $email['to_email_address']
                );

                $elasticsearchSavedId[] = $this->elasticsearchHelper->storeEmail(
                    $email['message_body'],
                    $email['message_subject'],
                    $email['to_email_address']
                );

                $this->redisHelper->storeRecentMessage(
                    Str::random(), 
                    $email['message_subject'], 
                    $email['to_email_address']
                );    
            }

            return $this->sendResponse(
                ['elastic_search_saved_ids' => $elasticsearchSavedId ],
                'Mail sent, Data stored to Redis and Elasticsearch'
            );
            
        } catch (\Exception $error) {
            return $this->sendError('Internal Server Error.', ['error'=> $error->getMessage()], $error->getCode());
        }

    }

    //  TODO - BONUS: implement list method
    public function list()
    {
        try {
            return $this->sendResponse($this->redisHelper->getEmailList(), 'List get Successfully.');
        } catch (\Exception $error) {
            return $this->sendError('Internal Server Error.', ['error'=> $error->getMessage()], $error->getCode());
        }
        
    }
}
