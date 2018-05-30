<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private $head = 'bedunder_';// DB Table 接頭辞
    /* ----------------------------------------------------
    //    Image Messages
    ----------------------------------------------------*/
    public function insert_image_messages($id = null, $userid = null)
    {
        if (isset($id) && isset($userid)) {
            $this->db->insert($head.'image_messages', [
                'message_id' => $id,
                'userid' => $userid,
            ]);
        }
    }
    public function get_image_messages($userid = null, $limit = null,$offset = null)
    {
        if (isset($userid)) {
            $this->db->from($head.'image_messages');
            $this->db->where('userid', $userid);
            $this->db->order_by('message_id', "asc");
            if (isset($limit)) {
                // LIMIT
            }
            if (isset($offset)) {
                // offset
            }
            $images = $this->db->get()->result();
            return $images;
        }
    }
    public function count_image_messages($userid = null)
    {
        if (isset($userid)) {
            $this->db->from($head.'image_messages');
            $this->db->where('userid', $userid);
            return $this->db->count_all_results();
        }
        return 0;
    }

    public function exist_image($userid, $id)
    {
        if (isset($id) && isset($userid)) {
            $this->db->from($head.'image_messages');
            $this->db->where('userid', $userid);
            $this->db->where('message_id', $id);
            $row = $this->db->get()->result();
            if (!empty($row)) {return true;}
            return false;
        }
    }
    /* ----------------------------------------------------
    //    Uniq UserID
    ----------------------------------------------------*/
    public function insert_uniq_users($id = null, $uniq = null)
    {
        if (isset($id) && isset($uniq)) {
            $this->db->insert($head.'uniq_users', [
                'userid' => $id,
                'uniqid' => $uniq,
            ]);
        }
    }
    public function get_uniq_users($uniq = null)
    {
        if (isset($uniq)) {
            $this->db->from($head.'uniq_users');
            $this->db->where('uniqid', $uniq);
            $this->db->limit(1);
            $user = $this->db->get()->row();
            if (isset($user)) {
                return $user->userid;
            }
            return null;
        }
    }
    /* ----------------------------------------------------
    //    line_send
    ----------------------------------------------------*/
    public function insert_line_send_requests($id = null, $userid = null)
    {
        if (isset($id) && isset($userid)) {
            $this->db->insert($head.'line_send_requests', [
                'message_id' => $id,
                'user_id' => $userid,
                'ts'=>time()
            ]);
        }
    }
    public function get_line_send_requests($userid = null, $limit = null,$offset = null)
    {
        if (isset($userid)) {
            $this->db->from($head.'line_send_requests');
            $this->db->where('user_id', $userid);
            $this->db->order_by('ts', "asc");
            if (isset($limit)) {
                // LIMIT
            }
            $images = $this->db->get()->result();
            return $images;
        }
    }

    public function count_line_send_requests($userid = null)
    {
        if (isset($userid)) {
            $this->db->from($head.'line_send_requests');
            $this->db->where('user_id', $userid);
            return $this->db->count_all_results();
        }
        return 0;
    }
}
