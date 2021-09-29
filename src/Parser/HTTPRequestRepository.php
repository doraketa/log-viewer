<?php

namespace App\Parser;

class HTTPRequestRepository
{
    protected array $logs = [];

    public function save(HTTPRequest $request)
    {
        $this->logs[] = $request;
    }

    public function getRequests(): array
    {
        return $this->logs;
    }
}