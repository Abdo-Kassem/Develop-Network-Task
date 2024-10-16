<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchRandomUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $response = Http::get('https://randomuser.me/api/');

            if ($response->successful()) {
                $results  = $response->json('results');
                Log::info('Random User Api Response ', context: $results );
            } else {
                Log::error('Failed To Fetch Random User Status Code: ' . $response->status());
            }

        } catch (Exception $ex) {
            Log::error('Error Occured When Fetch Random User Data: ' . $ex->getMessage());
        }
       
    }
}
