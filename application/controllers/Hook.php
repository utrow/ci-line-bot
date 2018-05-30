<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Botchan','Line', 'Db_mdl']);
        $this->load->helper('url');
    }

    public function index()
    {
        // LINE Webhookから情報を受け取る
        $raw = file_get_contents('php://input');
        $receive = json_decode($raw, true);
        // receiveの一部をオブジェクトに整理
        $event = $this->Line->hook_data();

        // 返信メッセージの格納 (5件まで)
        $messages = [];

        if ($event->all['message']['type'] == "image") {
            //もし画像が送られてきたら
            $messages[] = $this->case_image($event->id,$event->userid);
        } else {
            // テキストメッセージのとき、内容によって分岐
            switch ($event->message_text) {
                case $event->message_text == "みせて":
                    $messages[] =$this->case_view($messages);
                    break;
                default:
                    // オウム返し
                    $messages[] = [
                        'type' => 'text',
                        'text' => $event->message_text,
                    ];
                    break;
            }
        }
        // messagesをリプライで送信
        $this->Line->reply($messages);
    }


    /*-------------------------------------------------------------------
    テキストメッセージの分岐
    ------------------------------------------------------------------ */
    private function case_image($id, $userid)
    {
        // DBへ情報保存
        $this->Db_mdl->insert_image_messages($id, $userid);
        // DARK-AREA
        $this->Botchan->image_save($id, $userid);

        return [
            'type' => 'text',
            'text' => '素敵な画像をありがとう！',
        ];
    }

    private function case_view($messages)
    {
        // DBに保存されている画像IDを取得
        $images = $this->Db_mdl->get_image_messages($userid);
        if (!empty($images)) {
            // 画像IDが存在するとき
            $count = $this->Db_mdl->count_image_messages($user_id);

            $limit = 10;
            $top = 0;

            // 適当なユニークID発行
            $uniq_user = $this->gen_uniq_user($userid);
            $images = $this->Db_mdl->get_image_messages($userid, $limit, $top);

            // 画像カルーセルの要素
            $columns = [];

            foreach ($images as $value) {
                $columns[] = [
                    'imageUrl' => $this->base_url('images/user/' . $uniq_user . '/' . $value->message_id . '/thum'),
                    'action' => ['type' => 'uri', 'uri' => $this->base_url('images/user/' . $uniq_user . '/' . $value->message_id)]];
            }

            $messages[] = [
                'type' => 'template',
                'altText' => '画像を送信しました',
                'template' => [
                    'type' => 'image_carousel',
                    'columns' => $columns,
                ],
            ];
            $messages[] = [
                'type' => 'text',
                'text' => 'この前預かった画像を返すね',
            ];
        }
        else {
            $messages[] = [
                'type' => 'text',
                'text' => 'まだ画像が登録されていません。',
            ];
        }
        return $messages;
    }
     /*-------------------------------------------------------------------
    ユニークIDの生成
    ------------------------------------------------------------------ */
    private function gen_uniq_user($userid){
        // ユニークなユーザIDを生成
        // $uniq_userid = md5($userid.'_'.microtime()); こりゃ長い
        $uniq_userid = uniqid();
        $this->Db_mdl->insert_uniq_users($userid, $uniq_userid);
        
        return $uniq_userid;
    }
}
