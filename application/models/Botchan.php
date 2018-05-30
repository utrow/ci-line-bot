<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Botchan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Line');
    }
    public function image_save($id,$user){
        // 画像の準備
        $content = $this->Line->api_content($id);//BynaryIMAGE
        // 保存先の準備
        $d_media = "media/";
        if (!is_dir($d_media)) {
            // フォルダがなければ作る: media/
            mkdir($d_media);   
        }
        if (!is_dir($d_media.$user)) {
            // フォルダがなければ作る: media/{userid}/
            mkdir($d_media.$user); 
        }
        // JPG保存
        $filename = $d_media.$user.'/'.$id.'.jpg';
        file_put_contents($filename,$content);
        return $filename;
    }
    public function gen_uniq_user($userid){
        // !!! ユニークなユーザIDを生成
        $uniq_userid = md5($userid.'_'.microtime());
        return $uniq_userid;
    }
}