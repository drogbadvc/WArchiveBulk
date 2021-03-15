<?php

namespace App\scrap;

use Symfony\Component\DomCrawler\Crawler;

class Request
{
    /**
     * @var array
     */
    private array $urls = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->labelTreatment = new LabelTreatment();
    }


    /**
     * @param $response
     * @param $info
     */
    public function requests_callback($response, $info)
    {

    }


    /**
     * @return array
     */
    public function getUrls(): array
    {
        return $this->urls;
    }
}
