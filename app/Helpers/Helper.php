<?php

if (!function_exists('captcha_validation')) {
	/**
	* Captcha validation 
	**/
    function captcha_validation($captcha_text)
    {
        $client = new GuzzleHttp\Client();
        $response = $client->post(\App\SiteConstants::CAPTCHA_URL, [
				        'form_params' => [
				        'secret' => \App\SiteConstants::CAPTCHA_SECRET_KEY,
				        'response' => $captcha_text
				        ]
				    ]);
        $result = json_decode($response->getBody()->getContents());
        return $result;
    }
}