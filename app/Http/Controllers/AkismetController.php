<?php

namespace App\Http\Controllers;

use App\Repositories\SiteMetaRepository;
use App\SiteMeta;

class AkismetController extends Controller
{
    protected $apiKey;

    protected $site;

    /** @var SiteMetaRepository $siteMetaRepository */
    protected $siteMetaRepository;

    /** @var SiteMeta $siteMeta */
    protected $siteMeta;

    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static(new SiteMetaRepository());
        }

        return static::$instance;
    }


    protected function __construct(SiteMetaRepository $siteMetaRepository)
    {
        $this->siteMetaRepository = $siteMetaRepository;
        $this->siteMeta = $siteMetaRepository->getSiteMeta();
        $this->apiKey = $this->siteMeta->akismet_api_key;
        $this->site = urlencode($this->siteMeta->url);
    }

    /**
     * Authenticate Akismet API key.
     *
     * @return bool
     */
    public function verifyKey()
    {
        if (empty($this->apiKey)) {
            return false;
        }

        $request = 'key=' . $this->apiKey . '&blog=' . $this->site;
        $host = $http_host = 'rest.akismet.com';
        $path = '/1.1/verify-key';
        $port = 443;
        $akismet_ua = "Laraweb | Akismet";
        $content_length = strlen($request);
        $http_request = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $http_request .= "Content-Length: {$content_length}\r\n";
        $http_request .= "User-Agent: {$akismet_ua}\r\n";
        $http_request .= "\r\n";
        $http_request .= $request;
        $response = '';
        if (false != ($fs = @fsockopen('ssl://' . $http_host, $port, $errno, $errstr, 10))) {
            fwrite($fs, $http_request);
            while (!feof($fs))
                $response .= fgets($fs, 1160); // One TCP-IP packet
            fclose($fs);
            $response = explode("\r\n\r\n", $response, 2);
        }

        if ('valid' == $response[1]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if a comment is spam (returns true) or is ham (returns false).
     *
     * @param array $data
     * @return bool
     */
    public function commentIsSpam($data)
    {
        $request = 'blog=' . $this->site .
            '&user_ip=' . urlencode($data['ip']) .
            '&user_agent=' . urlencode($data['userAgent']) .
            '&referrer=' . urlencode($data['referrer']) .
            '&permalink=' . urlencode($data['permalink']) .
            '&comment_type=' . urlencode($data['commentType']) .
            '&comment_author=' . urlencode($data['author_name']) .
            '&comment_author_email=' . urlencode($data['author_email']) .
            '&comment_author_url=' . urlencode($data['author_url']) .
            '&comment_content=' . urlencode($data['body']);
        $host = $http_host = $this->apiKey . '.rest.akismet.com';
        $path = '/1.1/comment-check';
        $port = 443;
        $akismet_ua = "Laraweb | Akismet";
        $content_length = strlen($request);
        $http_request = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $http_request .= "Content-Length: {$content_length}\r\n";
        $http_request .= "User-Agent: {$akismet_ua}\r\n";
        $http_request .= "\r\n";
        $http_request .= $request;
        $response = '';
        if (false != ($fs = @fsockopen('ssl://' . $http_host, $port, $errno, $errstr, 10))) {
            fwrite($fs, $http_request);
            while (!feof($fs))
                $response .= fgets($fs, 1160); // One TCP-IP packet
            fclose($fs);
            $response = explode("\r\n\r\n", $response, 2);
        }

        if ('true' == $response[1]) {
            return true;
        } else {
            return false;
        }
    }
}
