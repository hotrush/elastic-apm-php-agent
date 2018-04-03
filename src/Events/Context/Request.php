<?php

namespace PhilKra\Events\Context;

class Request implements ContextInterface
{
    private $request = [];

    public function __construct()
    {
        $this->extractRequestData();
    }

    public function setRequestData(array $request)
    {
        $this->request = array_merge_recursive($this->request, $request);
    }

    private function extractRequestData()
    {
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);
        $serverProtocol = $_SERVER['SERVER_PROTOCOL'] ?? '';

        $this->request = [
            'http_version' => substr($serverProtocol, strpos($serverProtocol, '/')),
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'cli',
            'socket' => [
                'remote_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'encrypted' => isset($_SERVER['HTTPS']),
            ],
            'url' => [
                'protocol' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
                'hostname' => $_SERVER['SERVER_NAME'] ?? '',
                'port' => $_SERVER['SERVER_PORT'] ?? '',
                'pathname' => isset($_SERVER['REQUEST_URI'])
                    ? substr(
                        $_SERVER['REQUEST_URI'],
                        0,
                        strpos($_SERVER['REQUEST_URI'], '?') !== false
                            ? strpos($_SERVER['REQUEST_URI'], '?')
                            : null
                    )
                    : '',
                'search' => '?' . (($_SERVER['QUERY_STRING'] ?? '') ?? ''),
                'full' => isset($_SERVER['SERVER_NAME'])
                    ? (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].($_SERVER['REQUEST_URI'] ?? '')
                    : '',
            ],
            'headers' => $headers,
            'env' => $_SERVER, // @todo blocked env vars
            'body' => [], // @todo log form data
            'cookies' => $_COOKIE,
        ];
    }

    public function toArray(): array
    {
        return $this->request;
    }
}