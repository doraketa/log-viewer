<?php

namespace App\Parser;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use App\Exception\CreatePointerException;
use App\FileHelper\File;

class HTTPParser extends HTTPRequestRepository
{
    protected HTTPRequestRepository $repository;

    public function __construct(HTTPRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for parsing a file line by line.
     *
     * @param string $fileName          File Name
     * @throws CreatePointerException   Pointer Exception
     */
    public function parse(string $fileName): void
    {
        $file = File::openFile($fileName, "r+");
        $regexPattern = '/"\w+ (?<url>[\S]+).+" (?<statusCode>\d+) (?<contentLength>\d*)(.+".*" "(?<userAgent>.*)")?/';

        while (!feof($file)) {
            $line = fgets($file);
            $request = new HTTPRequest();
            preg_match($regexPattern, $line, $matches);

            $request
                ->url($matches["url"])
                ->size($matches["contentLength"])
                ->code($matches["statusCode"])
                ->userAgent($matches["userAgent"]);

            $this->repository->save($request);
            unset($request);
        }
    }

    /**
     * Method for getting a JSON object from a PHP array
     *
     * @return string|null
     */
    public function getJson(): ?string
    {
        $data = [
            'views'       => 0,
            'urls'        => 0,
            'traffic'     => 0,
            'crawlers'    => [],
            'statusCodes' => [],
        ];

        $urls = [];
        $crawlerDetector = new CrawlerDetect();

        $logs = $this->repository->getRequests();

        foreach ($logs as $log) {
            // Подсчет уникальных URL;
            $url = $log->getUrl();
            $size = $log->getSize();
            $status = $log->getCode();
            $crawler = $log->getUserAgent();

            if (!empty($log)) {
                $data["views"] ++;

                if (!array_key_exists($url, $urls)) {
                    $urls[$url] = true;
                    $data['urls'] ++;
                }
            }

            // Подсчет суммы данных
            if (!empty($size)) {
                $data['traffic'] += $size;
            }

            // Подсчет статусов
            if (!empty($status)) {
                $data['statusCodes'][$status] ++;
            }

            // Подсчет crawler
            if (!empty($crawler) && $crawlerDetector->isCrawler($crawler)) {
                $crawlerAgent = $crawlerDetector->getMatches();
                $data['crawlers'][$crawlerAgent] ++;
            }
        }

        return json_encode($data);
    }
}
