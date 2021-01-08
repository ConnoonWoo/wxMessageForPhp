<?php
/**
 * Created by PhpStorm.
 * User: qilong.wu
 * Date: 2021-01-08
 * Time: 23:14
 */
namespace App\Http\Controllers;

use App\Services\IndexService;

class IndexController extends Controller {
    //public $indexService;

    public function initialize() {
        //$this->indexService = new IndexService();
    }


    public function index() {
        return view('index');
    }

    // 获取用户信息
    public function getUser() {
        $indexService = new IndexService();
        // todo 重定向了没有返回值，能取到？ 不然所有的请求都要到重定向那边分发再重定向？
        $openId = $indexService->getWxMsg(1);
    }

    // 获取qrCode
    public function getQrCode() {
        $indexService = new IndexService();
        // todo 重定向做法
        $indexService->getWxMsg(2);
    }

    /**
     * 获取用户的openid
     * @return mixed
     */
    public function baseAuth() {
       $indexService = new IndexService();
       return $indexService->baseAuth();
    }


    /**
     * 生成二维码
     */
    public function createQr() {
        $openid = input("openid");
        //TODO 二维码url,可以做一些核销操作
        $text = "http://localhost/public/index.php/Index/applied?openid=$openid";
        // TODO 引入插件，生成QrCode
        //$url = make_qrcode($text);

    }

    /**
     * 获取二维码
     */
    public function findQr() {
        $openid = $_GET['openid'];
        //TODO findQr
    }
}