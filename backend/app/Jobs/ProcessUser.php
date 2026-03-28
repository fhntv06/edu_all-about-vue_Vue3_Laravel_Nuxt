<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessUser implements ShouldQueue
{
    use Queueable;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger(
            'Job ProcessUser is work!',
            [
                'data' => $this->data,
                'delay' => $this->delay,
            ],
        );
    }
}
