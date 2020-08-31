<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {    

    protected $http_code = 400;
    protected $status = 'failure';
    protected $message;
    protected $data = array();

    public function __construct() {
        parent::__construct();

        $this->load->model('M_mahasiswa', 'model');
        $this->load->library('form_validation');
    }

    public function index() {
        $http_code = 200;
        $status = 'success';
        $data = $this->model->fetchAll();
        
        $response = array(
            'status'    => $status,
            'data'      => $data
        );

        echo json_encode($response);
    }

    public function addMahasiswa() {
        try {
            // Check Http Method
            $method = $this->input->method(TRUE);
            if ($method != 'POST') throw new Exception('http_method');
            
            // Check String Name
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[50]');
            if (!$this->form_validation->run()) throw new Exception('form_validation');

            // Create a new Mahasiswa
            $data = array('name' => $this->input->post('name', TRUE));
            $inserted_id = $this->model->insert($data);

            $this->http_code = 201;
            $this->status = 'success';
            $this->message = 'Successfully createa a new data';
            $this->data = array('inserted_id' => $inserted_id);
        } catch (Exception $e) {
            switch ($e->getMessage()) {
                case 'http_method':
                    $this->message = 'Http Request must be POST';
                break;

                case 'form_validation':
                    $this->message = 'Bad Request';
                    $this->data = $this->form_validation->error_array();
                break;
            }                    
        } finally {
            $response = array(
                'status'    => $this->status,
                'message'   => $this->message,
                'data'      => $this->data
            );
        }

        $this->output
			->set_status_header($this->http_code)
			->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function exit_controller() {
        $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('foo' => 'bar')));
            // ->_display();
        // exit(0);
    }
}