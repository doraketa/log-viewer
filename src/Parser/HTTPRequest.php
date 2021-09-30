<?php

namespace App\Parser;

class HTTPRequest
{
    /** @var string Storage of CODE */
    protected string $code;

    /** @var string Storage of SIZE */
    protected string $size;

    /** @var string Storage of URL */
    protected string $url;

    /** @var string Storage of USERAGENT */
    protected string $userAgent;

    /**
     * Method for setting $code
     *
     * @param string $code
     * @return $this
     */
    public function code(string $code): ?self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Method for setting $size
     *
     * @param string $size
     * @return $this
     */
    public function size(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Method for setting $url
     *
     * @param string $url
     * @return $this
     */
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Method for setting $userAgent
     *
     * @param string $userAgent
     * @return $this
     */
    public function userAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Method for getting $size
     *
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * Method for getting $code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Method for getting $url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Method for getting $userAgent
     *
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }
}
