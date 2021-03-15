<?php
namespace App\controller;

use App\concern\Treatment;
use Slim\Views\PhpRenderer;

class WebArchController
{
    public function index($request, $response, $args): \Psr\Http\Message\ResponseInterface
    {
        $renderer = new PhpRenderer('public/html');
        try {
            return $renderer->render($response, "index.php", $args);
        } catch (\Throwable $e) {
        }
    }

    public function form($request, $response, array $args): \Psr\Http\Message\ResponseInterface
    {
        $domainParse = new Treatment();
        $domains = $request->getParsedBody();
        $line = $domainParse->domainParse($domains['domains']);
        $curl = new WebArchListController();
        $arr_domains = $curl->archive($line);
        $arr_domains = $curl->capture($line);

        $templateVariables = [
            "domains" => $arr_domains
        ];

        $renderer = new PhpRenderer('public/html', $templateVariables);
        try {
            $response = $renderer->render($response, "index.php");
        } catch (\Throwable $e) {
        }
        return $response;
    }
}
