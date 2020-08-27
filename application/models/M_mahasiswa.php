<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mahasiswa extends CI_Model {
    
    protected $table;

    public function __construct(){     
        parent::__construct();
        
        $this->load->database();
        $this->table = 'mahasiswa';
    }

    public function fetchAll() {
        return $this->db->get($this->table)->result();
    }

    public function fetchSelected($where) {
        if (count($where) > 0) $this->db->where($where);
        return $this->db->get($this->table)->row();
    }

    public function countAll() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where) {
        $this->db->delete($this->table, $where);
    }
}