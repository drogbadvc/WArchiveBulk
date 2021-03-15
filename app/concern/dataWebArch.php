<?php

namespace App\concern;

use App\helpers\ToolsHelp;

class dataWebArch
{
    private array $Data = [];
    private array $Year = [];
    private ToolsHelp $tools;

    /**
     * dataWebArch constructor.
     */
    public function __construct()
    {
        $this->tools = new ToolsHelp();
    }

    public function archiveRequest($response, $info)
    {
        $decode = json_decode($response, true);
        $count = $this->tools->countHits($decode['years']);
        $lastHit = $decode['last_ts'];
        $firstHit = $decode['first_ts'];

        $lastYear = date('Y', (strtotime($lastHit)));
        $this->Year[] = $lastYear;
        $domainName = $this->tools->getDomain($info['url']);
        $this->Data[$domainName] =  ['total' => $count, 'last' =>$lastHit, 'first' => $firstHit];
    }

    public function captureRequest($response, $info) {
        $decode = json_decode($response, true);
        $domainName = $this->tools->getDomain($info['url'], true);
        $items = $decode['items'];
        $date = [];
        foreach($items as $item) {
            if(strlen($item[0]) === 3) {
                $month = '0'.substr($item[0],0,1);
                $day = substr($item[0],1);
                $date[] = ['month' => $month, 'day' => $day];
            }elseif(strlen($item[0]) === 4) {
                $month = substr($item[0],0,2);
                $day = substr($item[0],2);
                $date[] = ['month' => $month, 'day' => $day];
            }
        }
        $this->Data[$domainName]['date'] = $date;
    }

    /**
     * @return array
     */
    public function GetData(): array
    {
        return $this->Data;
    }

    public function GetYear(): array
    {
        return $this->Year;
    }
}