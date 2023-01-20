<?php

namespace Tests\Support;

use App\Consts\Tables\ThreadsConst;

trait TestPost
{
    public array $posts;

    public function postSetUp(): void
    {
        $this->posts = [];
        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->posts[] = $modelFQCN::factory()->create();
        }
    }
}
