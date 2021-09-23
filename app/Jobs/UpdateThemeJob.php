<?php

namespace App\Jobs;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateThemeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $theme = Theme::where('user_id', $this->user_id)->first();
        if (!$theme) {
            $user = User::find($this->user_id);
            info($user->name . ' 的模板文件没找到');
            return;
        }
        $source = $theme->source_theme;
        if (!$source) {
            $user = User::find($this->user_id);
            info($user->name . ' 的模板文件为空');
            return;
        }
        $pos = mb_strpos($source, "<body");
    }
}
