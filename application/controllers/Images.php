<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Images extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Line', 'Db_mdl']);
        $this->load->library(['parser']);
    }

    public function index()
    {

    }
    public function nama()
    {
        $content = $this->Line->api_content(7999565527618); //BynaryIMAGE
        header('Content-type: image/jpeg');
        // echo base64_decode($response);
        echo $content;
    }

    public function user($uniq = null, $imageid = null, $thum = null)
    {
        if (isset($uniq)) {
            $userid = $this->Db_mdl->get_uniq_users($uniq);
            if (isset($imageid)) {
                if (!$this->Db_mdl->exist_image($userid, $imageid)) {
                    return; // USERとIDの組み合わせが違えば中断
                }
                else if (isset($thum) && $thum == 'thum') {
                    //個別JPGファイル
                    $content = $this->Line->api_content($imageid); //BynaryIMAGE
                    header('Content-type: image/jpeg');
                    // echo base64_decode($response);
                    echo $content;
                    exit;
                    
                } else {
                    // 個別画像ページ
                    $image_url = 'http://hook.mars.jp/images/user/' . $uniq . '/' . $value->message_id.'/thum';
                    $req='https://hook-marsjp.ssl-netowl.jp/images/req/' . $uniq . '/' . $value->message_id. '/';
                    $this->parser->parse('image_item',[
                        'image_url'=>$image_url,
                        'req_url' =>$req
                    ]);
                }
            }

        }
    }
    public function req($uniq=null,$message_id=null,$del=null){
        if (isset($uniq)&&isset($message_id)) {
            if(isset($del)&&$del='del'){

            }
            else{}
        }
    }

}
