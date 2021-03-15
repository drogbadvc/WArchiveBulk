<?php

namespace App\controller;

use App\concern\dataWebArch;
use App\scrap\RollingCurl;
use App\scrap\RollingCurlRequest;

class WebArchListController
{
    private string $url = 'https://web.archive.org/__wb/sparkline?output=json&url=';
    private string $capture = 'https://web.archive.org/__wb/calendarcaptures/2?url=';
    private dataWebArch $dataWebArch;

    /**
     * WebArchListController constructor.
     */
    public function __construct() {
        $this->dataWebArch = new dataWebArch();
    }

    /**
     * @param $domain
     * @return array
     */
    public function archive($domain): array
    {
        $rollingCurl = $this->rollingCurlRequest($this->dataWebArch, $domain);
        return $this->dataWebArch->GetData();
    }

    /**
     * @param $domain
     * @return array
     */
    public function capture($domain): array
    {

        $rollingCurl = $this->rollingCurlRequest($this->dataWebArch, $domain, true);
        return $this->dataWebArch->GetData();
    }
    /**
     * @param $data
     * @param $domain
     * @param bool $capture
     * @return RollingCurl
     */
    private function rollingCurlRequest($data, $domain, $capture = false): RollingCurl
    {

        $rc = new RollingCurl([$data, $capture ? "captureRequest" : 'archiveRequest']);

        foreach ($domain as $key => $url) {
            $url = trim($url);
            $headers = array(
                'authority: web.archive.org',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36',
                'accept: */*',
                'referer: https://web.archive.org/web/*/' . $url,
                'accept-language: fr,es;q=0.9,en-US;q=0.8,en;q=0.7',
                'sec-fetch-site: same-origin',
                'sec-fetch-mode: cors',
                'sec-fetch-dest: empty'
            );
            $rc->options = array(CURLOPT_HTTPHEADER => $headers);
            if($capture) {
                $req = new RollingCurlRequest($this->capture . $url . '&date='.$this->dataWebArch->GetYear()[$key].'&groupby=day');
            }else{
                $req = new RollingCurlRequest($this->url . $url . '&collection=web');
            }

            $rc->add($req);

        }
        $rc->execute();
        return $rc;
    }
}