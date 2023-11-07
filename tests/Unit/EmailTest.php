<?php

namespace Tests\Unit;

use App\Jobs\SendMailJob;
use App\Services\EmailJobService;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;

class EmailTest extends TestCase
{
    /**
     * Test a job dispatch successfully
     *
     * @return void
     */

    public function test_email_job_is_dispatch_successfully()
    {
        Bus::fake();
        
        $emailJobService = new EmailJobService();
        $emailJobService->dispatchEmailJob(
            "Messag Body",
            "Message Subject",
            "test@test.com"
        );
        Bus::assertDispatched(function (SendMailJob $job) {
            return $job;
        });

    }

}
