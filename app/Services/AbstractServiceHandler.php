<?php

namespace App\Services;

use App\Contracts\ServiceHandlerInterface;
use App\Services\Flight\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractServiceHandler implements ServiceHandlerInterface
{
    protected ?ServiceHandlerInterface $successor = null;

    public function setSuccessor(?ServiceHandlerInterface $successor): void
    {
        $this->successor = $successor;
    }

    protected function processNext(Request $request, Model $model, Response $props)
    {
        if (!$this->successor !== null)
        {
            $this->successor->handle($request, $model, $props);
        }
    }
}
