<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CurlTrait
{
    /**
     * Define Header for API call
     */
    public $curlHeader = [];

    public function __construct()
    {
        $this->curlHeader = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Send Post Request Using Guzzel Method.
     *
     * @param string $route
     * @param array $data parameters
     *
     * @return array
     */
    public function callExternalPostApi($route, $data = [])
    {
        try {
            $response = Http::post($route, $data);

            return $response->json();
        } catch (\Exception $ex) {
            return abort(404);
        }
    }

    /**
     * Send Get Request Using Guzzel Method with header n url
     *
     * @param string $url request url
     * @param array $params request parameter
     * @param string $token
     *
     * @return array
     */
    public function callInternalGetApi($route, $token, $data = [])
    {
        try {
            $this->curlHeader['Authorization'] = 'Bearer ' . $token;
            $response = Http::withHeaders($this->curlHeader)
                ->withQueryParameters($data)
                ->get($route);
            return $response->json();
        } catch (\Exception $ex) {
            return abort(404);
        }
    }

    /**
     * Send Delete Request Using Guzzel Method with header n url
     *
     * @param string $route
     * @param string $token
     * @param array $data
     *
     * @return array
     */
    public function callInternalDeleteApi($route, $token, $data = [])
    {
        try {
            $this->curlHeader['Authorization'] = 'Bearer ' . $token;

            $response = Http::withHeaders($this->curlHeader)
                ->delete($route, $data);

            return $response->json();
        } catch (\Exception $ex) {
            return abort(404);
        }
    }

    /**
     * Send Post Request Using Guzzel Method with header.
     *
     * @param string $route
     * @param string $token
     * @param array $data
     *
     * @return array
     */
    public function callExternalPostWithHeaderApi($route, $token, $data = [])
    {
        try {
            $this->curlHeader['Authorization'] = 'Bearer ' . $token;
            $response = Http::withHeaders($this->curlHeader)->post($route, $data);

            return $response->json();
        } catch (\Exception $ex) {
            return abort(404);
        }
    }
}
