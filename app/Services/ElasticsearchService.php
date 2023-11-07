<?php 

namespace App\Services;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Elasticsearch\ClientBuilder;
use Exception;

class ElasticsearchService implements ElasticsearchHelperInterface {

    private $collection = 'emails_store';

    public function storeEmail( string $messageBody, string $messageSubject, string $toEmailAddress ): mixed
    {
        try {

            $host = env('ELASTICSEARCH_HOST', 'elasticsearch');
            $port = env('ELASTICSEARCH_PORT', 9200);

            $client = ClientBuilder::create()
                ->setHosts(["$host:$port"])
                ->build();

            $data = [
                'body' => [
                    'message_body' => $messageBody,
                    'message_subject' => $messageSubject,
                    'to_email_address' => $toEmailAddress
                ],
                'index' => $this->collection,
            ];
            $responses = $client->index($data);
            return $responses['_id'];
                
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode()); 
        }
        
    }
}