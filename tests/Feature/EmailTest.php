<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailTest extends TestCase
{

    /**
     * Test email api Unauthorised 
     *
     * @return void
     */
    public function test_the_email_route_return_unauthorised_if_not_logged_in()
    {
        $response = $this->postJson('/api/989/send?api_token=4|VsKvQkzhHvMOSDkJbdhgsaNVFj7EFKTbWdHehc4u');
        $response->assertStatus(401);
    }


    /**
     * Test email api Requested user not found
     *
     * @return void
     */

    public function test_the_email_route_return_404_if_user_not_found()
    {
        $response = $this->postJson('/api/1234/send?api_token=1|9vxl4CV4RG1UGgopVEg9qc7PmAYHmwdoytTXBaAU');
        $response->assertStatus(404);
    }

    /**
     * Test email api Requested user is not current authorized user
     *
     * @return void
     */

    public function test_the_email_route_return_401_if_user_not_match_with_current_auth_user()
    {
        $response = $this->postJson('/api/1/send?api_token=1|10vxl4CV4RG1UGgopVEg9qc7PmAYHmwdoytTXBaAU');
        $response->assertStatus(401);
    }

    /**
     * Test email api validation error
     *
     * @return void
     */

    public function test_the_email_route_validation_error_if_not_pass_data()
    {
        $response = $this->postJson('/api/1/send?api_token=1|9vxl4CV4RG1UGgopVEg9qc7PmAYHmwdoytTXBaAU');
        $response->assertStatus(422);
    }


    /**
     * Test email api successfull response.
     *
     * @return void
     */

     public function test_the_email_route_return_successfull_response_if_validation_pass()
     {
        $emails = [
            "emails" =>[
                [
                    "message_subject" =>"Message Subject",
                    "message_body" => "Message Body",
                    "to_email_address" => "test@gmail.com"
                ],
                [
                    "message_subject" =>"Message Subject 1",
                    "message_body" => "Message Body 1",
                    "to_email_address" => "test@gmail.com"
                ],
            ]
        ];

        $response = $this->postJson('/api/1/send?api_token=1|9vxl4CV4RG1UGgopVEg9qc7PmAYHmwdoytTXBaAU', $emails);
        $response->assertStatus(200);
     }

    /**
     * Test the list Api
     *
     * @return void
     */
    public function test_the_list_route_return_successfull_response()
    {
        $response = $this->get('/api/list');

        $response->assertStatus(200);
    }

}
