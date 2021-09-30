<?php

namespace App\Parser;

class HTTPRequestRepository
{
    /** @var array Local storage (repository) */
    protected array $logs = [];

    /**
     * Saving an HTTPRequest instance
     *
     * @param HTTPRequest $request
     */
    public function save(HTTPRequest $request)
    {
        $this->logs[] = $request;
    }

    /**
     * Method for getting all request from array (repository)
     *
     * @return array
     */
    public function getRequests(): ?array
    {
        if ($this->logs === null) {
            return null;
        }
        return $this->logs;
    }
}
