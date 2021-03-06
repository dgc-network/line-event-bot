<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/*
 * This polyfill of hash_equals() is a modified edition of https://github.com/indigophp/hash-compat/tree/43a19f42093a0cd2d11874dff9d891027fc42214
 *
 * Copyright (c) 2015 Indigo Development Team
 * Released under the MIT license
 * https://github.com/indigophp/hash-compat/blob/43a19f42093a0cd2d11874dff9d891027fc42214/LICENSE
 */
if (!function_exists('hash_equals')) {
    defined('USE_MB_STRING') or define('USE_MB_STRING', function_exists('mb_strlen'));

    /**
     * @param string $knownString
     * @param string $userString
     * @return bool
     */
    function hash_equals($knownString, $userString)
    {
        $strlen = function ($string) {
            if (USE_MB_STRING) {
                return mb_strlen($string, '8bit');
            }

            return strlen($string);
        };

        // Compare string lengths
        if (($length = $strlen($knownString)) !== $strlen($userString)) {
            return false;
        }

        $diff = 0;

        // Calculate differences
        for ($i = 0; $i < $length; $i++) {
            $diff |= ord($knownString[$i]) ^ ord($userString[$i]);
        }
        return $diff === 0;
    }
}

class LINEBotTiny
{
    /** @var string */
    private $channelAccessToken;
    /** @var string */
    private $channelSecret;

    /**
     * @param string $channelAccessToken
     * @param string $channelSecret
     */
    public function __construct($channelAccessToken, $channelSecret)
    {
        $this->channelAccessToken = $channelAccessToken;
        $this->channelSecret = $channelSecret;
    }

    /**
     * @return mixed
     */
    public function parseEvents()
    {
     
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            error_log('Method not allowed');
            //exit();
            return;
        }

        $entityBody = file_get_contents('php://input');

        if ($entityBody === false || strlen($entityBody) === 0) {
            http_response_code(400);
            error_log('Missing request body');
            //exit();
            return;
        }

        if (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {
            http_response_code(400);
            error_log('Invalid signature value');
            //exit();
            return;
        }

        $data = json_decode($entityBody, true);
        if (!isset($data['events'])) {
            http_response_code(400);
            error_log('Invalid request body: missing events property');
            //exit();
            return;
        }
        return $data['events'];
   
    }

    /**
     * @param array<string, mixed> $message
     * @return void
     */
    public function replyMessage($message)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => json_encode($message),
            ],
        ]);

        $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }
    }

    /**
     * @param string $userId
     * @return object
     */
    public function getProfile($userId)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'GET',
                'header' => implode("\r\n", $header),
                //'content' => json_encode($userId),
            ],
        ]);

        $response = file_get_contents('https://api.line.me/v2/bot/profile/'.$userId, false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }

        $response = stripslashes($response);
        $response = json_decode($response, true);
        
        return $response;
    }

    /**
     * @param string $groupId
     * @return object
     */
    public function getGroupSummary($groupId)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'GET',
                'header' => implode("\r\n", $header),
            ],
        ]);

        $response = file_get_contents('https://api.line.me/v2/bot/group/'.$groupId.'/summary', false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }

        $response = stripslashes($response);
        $response = json_decode($response, true);
        
        return $response;
    }

    /**
     * @param string $groupId, $userId
     * @return object
     */
    public function getGroupMemberProfile($groupId, $userId)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'GET',
                'header' => implode("\r\n", $header),
            ],
        ]);

        $response = file_get_contents('https://api.line.me/v2/bot/group/'.$groupId.'/member'.'/'.$userId, false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }

        $response = stripslashes($response);
        $response = json_decode($response, true);
        
        return $response;
    }

    /**
     * @param string $messageId
     * @return object
     */
    public function getContent($messageId)
    {
        $header = array(
            //'Content-Type: application/octet-stream',
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'GET',
                'header' => implode("\r\n", $header),
            ],
        ]);
        $response = file_get_contents('https://api-data.line.me/v2/bot/message/'.$messageId.'/content', false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }
        return $this->save_temp_image($response);
        //return var_dump($response);
        //return $response;

    }

 /**
  * Save the submitted image as a temporary file.
  *
  * @todo Revisit file handling.
  *
  * @param string $img Base64 encoded image.
  * @return false|string File name on success, false on failure.
  */
  protected function save_temp_image($img)
  {
      // Strip the "data:image/png;base64," part and decode the image.
      $img = explode(',', $img);
      $img = isset($img[1]) ? base64_decode($img[1]) : base64_decode($img[0]);
      if (!$img) {
          return false;
      }
      // Upload to tmp folder.
      $filename = 'user-feedback-' . date('Y-m-d-H-i-s');
      $tempfile = wp_tempnam($filename, sys_get_temp_dir());
      if (!$tempfile) {
          return false;
      }
      // WordPress adds a .tmp file extension, but we want .png.
      if (rename($tempfile, $filename . '.png')) {
          $tempfile = $filename . '.png';
      }
      if (!WP_Filesystem(request_filesystem_credentials(''))) {
          return false;
      }
      /**
       * WordPress Filesystem API.
       *
       * @var \WP_Filesystem_Base $wp_filesystem
       */
      global $wp_filesystem;
      //$wp_filesystem->chdir(get_temp_dir());
      $success = $wp_filesystem->put_contents($tempfile, $img);
      if (!$success) {
          return false;
      }
      //return $tempfile;
      $upload = wp_get_upload_dir();
      $url = '<img src="'.$upload['url'].'/'.$filename. '.png">';
      $url = '<img src="'.sys_get_temp_dir().$filename. '.png">';
      //$url = $wp_filesystem->wp_content_dir().'/'.$filename;
      return $url;
  }
  
    /**
     * @param string $body
     * @return string
     */
    private function sign($body)
    {
        $hash = hash_hmac('sha256', $body, $this->channelSecret, true);
        $signature = base64_encode($hash);
        return $signature;
    }
}