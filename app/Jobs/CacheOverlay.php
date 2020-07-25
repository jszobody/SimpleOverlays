<?php

namespace App\Jobs;

use App\Overlay;
use App\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CacheOverlay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $overlay;

    public function __construct(Overlay $overlay)
    {
        $this->overlay = $overlay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->overlay->generate();
    }
}
