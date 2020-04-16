<?php

/**
 * Basic HTTP Client request
 *
 * @version    7.0
 * @package    core
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class AdiantiHttpClientModify
{
    /**
     * Execute a HTTP request
     *
     * @param $url URL
     * @param $method method type (GET,PUT,DELETE,POST)
     * @param $params request body
     */
    public static function request($url, $method = 'POST', $params = [], $authorization = null)
    {
        $ch = curl_init();
        
        if ($method == 'POST' OR $method == 'PUT')
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_POST, true);
     
        }
        else if ($method == 'GET' OR $method == 'DELETE')
        {
            $url .= '?'.http_build_query($params);
        }
       
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 10
        );
        
        if (!empty($authorization))
        {
            $defaults[CURLOPT_HTTPHEADER] = ['Authorization: '. $authorization];
        }
        
        curl_setopt_array($ch, $defaults);
        $output = curl_exec ($ch);
		
		$info_request = curl_getinfo ( $ch );
		
		$resultado = array($output, $info_request);
		
        return $resultado;
    }
}