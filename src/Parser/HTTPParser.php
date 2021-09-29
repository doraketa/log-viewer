<?php

namespace App\Parser;

use App\FileHelper\File;
use App\Parser\HTTPRequest;
use App\Parser\HTTPRequestRepository;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class HTTPParser extends HTTPRequestRepository
{
    protected HTTPRequestRepository $repository;

    public function __construct(HTTPRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function parse(string $fileName)
    {
        $file = File::openFile($fileName, "r+");

        while (!feof($file))
        {
            $line = fgets($file);
            $request = new HTTPRequest();
            preg_match(
                '/"\w+ (?<url>[\S]+).+" (?<statusCode>\d+) (?<contentLength>\d*)(.+".*" "(?<userAgent>.*)")?/',
                $line,
                $matches
            );

            //preg_match_all($regEx,  $line, $matches, PREG_SET_ORDER);

            $request
                ->url($matches["url"])
                ->size($matches["contentLength"])
                ->code($matches["statusCode"])
                ->userAgent($matches["userAgent"]);

            $this->repository->save($request);
            unset ($request);
        }
    }

    public function getJson(): void
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

        foreach ($logs as $log)
        {
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

        dump(json_encode($data));
    }


}