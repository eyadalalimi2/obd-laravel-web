<?php

namespace App\Events;

use App\Models\ObdCode;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CodeUpdated
{
    use Dispatchable, SerializesModels;

    public ObdCode $code;

    public function __construct(ObdCode $code)
    {
        $this->code = $code;
    }
}
