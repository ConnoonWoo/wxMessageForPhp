<?php
/**
 * Created by PhpStorm.
 * User: qilong.wu
 * Date: 2021-01-09
 * Time: 00:12
 */
namespace App\Services;

class IndexService {
    public $config = [
        "appid"     => "wx49ecb902dc9994ed",
        "appsecret" => "3bb0161785c66064ba8b295fe4e84a84"
    ];


    public function getWxMsg($status) {
        //回调函数
        $appid = $this->config['appid'];
        // TODO 回调link
        $redirect_uri = urlencode('http://localhost/wxMessageForPhp/public/index.php/baseAuth');

        //授权url
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=$status#wechat_redirect";

        //如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
        header("location:$url");
    }

    /**
     * 获取用户的openid
     * @return mixed
     */
    public function baseAuth() {
        header("Content-type:text/html;charset=utf-8");
        // 静默授权,获取code
        $code = $_GET['code'];
        $status = $_GET['state'];
        // 通过code换取网页授权access_token和openid
        $curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->config['appid'] . '&secret=' . $this->config['appsecret'] . '&code=' . $code . '&grant_type=authorization_code';
        $content = $this->httpGet($curl);
        $result = json_decode($content, TRUE);

        $openid = $result['openid'];
        return $openid;
        //if (1 == $status) {
        //    //生成二维码
        //    $url = "http://localhost/public/index.php/Index/createQr?openid=$openid";
        //} elseif(2 == $status) {
        //    //获取二维码
        //    $url = "http://localhost/public/index.php/Index/findQr?openid=$openid";
        //}
        //header("location:$url");
    }

    //curl方式获取返回值
    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        if ($res === FALSE) {
            return "网络请求出错: " . curl_error($curl);
            exit();
        }
        curl_close($curl);

        return $res;
    }

}