<?php

namespace Controllers;

use Silex\Application;


 
class InstagramController
{

    public function showInstagram(Application $app)
    {
        $url = 'https://api.instagram.com/v1/tags/homerefill/media/recent?access_token=847573489.faa8411.f2877cda6ddd491fb26646c5589d17be';
        $result = $this->comunicarUrl($url);
        
        $media_data = [];
        foreach ($result['data'] as $media) {
            $m = [];
            if ($media['type'] === 'video') {
                $m['video'] = [
                    'poster'=> $media['images']['low_resolution']['url'],
                    'source'=> $media['videos']['standard_resolution']['url']
                ];
            } else {
                $m['image'] = ['source' => $media['images']['low_resolution']['url']];
            }
            $m['meta'] = [
                'id' => $media['id'],
                'avatar' => $media['user']['profile_picture'],
                'username' => $media['user']['username'],
                'comment' => $media['caption']['text']
            ];
            $media_data[] = $m;
            //echo "<xmp>".print_r($media,true)."</xmp>";
        }

        return $app['mustache']->render('listagem', array(
            'media' => $media_data,
        ));

    }
    
    public function comunicarUrl($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2
        ));
        
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
   
}
