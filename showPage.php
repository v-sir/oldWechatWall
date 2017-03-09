<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/11/21
 * Time: 10:17
 */

class MediaInfo {
    // ��΢У�ṩ
    const API_KEY = '043946CE43F17CF4';
    const API_SECRET = '19BFBDFD9151375F3DCC790C6F8253B8';

    public function getInfo() {
        $media_id = 'gh_fa665021dc10';
        $open_url = 'http://weixiao.qq.com/common/get_media_info';

        $param_array = array(
            'media_id' => $media_id,
            'api_key' => self::API_KEY,
            'timestamp' => time(),
            'nonce_str' => $this->genNonceStr(),
        );

        $param_array['sign'] = $this->calSign($param_array);
        $reponse = $this->post($open_url, json_encode($param_array));
        echo $reponse;
    }

    /**
     * ����32λ����ַ���
     * @return string
     */
    public function genNonceStr() {
        return strtoupper(md5(time() . mt_rand(0, 10000) . substr('abcdefg', mt_rand(0, 7))));
    }

    /**
     * curl post ����
     * @param string $url
     * @param string $json_data json�ַ���
     * @return json
     */
    public function post($url, $json_data, $https = true) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * ����ǩ��
     * @param array $param_array
     * @return string
     */
    public function calSign($param_array) {
        $names = array_keys($param_array);
        sort($names, SORT_STRING);

        $item_array = array();
        foreach ($names as $name) {
            $item_array[] = "{$name}={$param_array[$name]}";
        }

        $str = implode('&', $item_array) . '&key=' . self::API_SECRET;
        return strtoupper(md5($str));
    }
}

$object = new MediaInfo();
$object->getInfo();

?>