<?php

namespace App\Jobs;

use App\Models\AppConfig;
use App\Models\CurrencyRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCurrencyRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $source = $this->source;
        $currencies = AppConfig::where('key', 'currencies')->first();
        $json_str = file_get_contents('http://apilayer.net/api/live?access_key=2e422216df0d350cb64ae4fb3eec670d&currencies=' .
            $currencies->value
            . '&source=' . $source . '&format=1');
        $json = json_decode($json_str);
        $quotes = $json->quotes;
        foreach ($quotes as $quote => $rate) {
            CurrencyRate::updateOrCreate(
                ['quote' => $quote],
                ['rate' => $rate]
            );
            info($quote . ' rate updated to ' . $rate);
        }
    }
}
