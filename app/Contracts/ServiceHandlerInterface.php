<?php

namespace App\Contracts;

use App\Services\Flight\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ServiceHandlerInterface
{
    public function handle(Request $request, Model $model, Response $props): void;
}
