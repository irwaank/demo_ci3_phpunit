<?php

/**
 * @author Irwan Kurniadi
 * @copyright 2020 - Irwan Kurniadi
 */
class Mahasiswa_addMahasiswa_test extends TestCase {
    
    /**
     * @testdox init mahasiswa with seeds 3 data
     */
     public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->setPath(APPPATH.'tests/database_seeds/');
		$CI->seeder->call('MahasiswaSeeder');
    }

    /**
     * @testdox init library, object and variable
     */
    public function setUp() {
        $this->output = NULL;
        $this->new_mahasiswa = array('name' => 'Irwan');
    }    

    /**
     * @param String which is HTPP MEthod
     */
    private function exec($http_method = 'POST') {
        $output = $this->request($http_method, 'mahasiswa/addMahasiswa', $this->new_mahasiswa);        
		$this->output = json_decode($output);
    }

    /**
     * @param Int which is length of string
     */
    private function generate_string($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /**
     * @test
     * @testdox it should return 400 for request wih http method GET
     */
    public function it_should_return_400_with_http_method_get() {
        $this->exec('GET');
        
        $this->assertResponseCode(400);
        $this->assertIsObject($this->output);
        $this->assertEquals('failure', $this->output->status);
    }

    /**
     * @test
     * @testdux it should return 400 if name is empty
     */
    public function it_should_return_400_if_name_empty() {
        $this->new_mahasiswa['name'] = '';
        $this->exec();
        
        $this->assertResponseCode(400);
        $this->assertGreaterThan(0, count($this->output->data));
        $this->assertContains('required', $this->output->data->name);
    }

    /**
     * @test
     * @testdux it should return 400 if name is empty
     */
    public function it_should_return_400_if_name_empty_2() {        
        $this->new_mahasiswa['name'] = '';
        try {
			$this->request('POST', 'mahasiswa/addMahasiswa', $this->new_mahasiswa);
		} catch (CIPHPUnitTestExitException $e) {
			$output = ob_get_clean();
		}
        #$output = $this->request('POST', 'mahasiswa/addMahasiswa', $this->new_mahasiswa);
		#$this->output = json_decode($output);
        
        $this->assertResponseCode(400);
        #$this->assertGreaterThan(0, count($this->output->data));
        #$this->assertContains('required', $this->output->data->name);
    }

    /**
     * @test
     * @testdux it should return 400 if name less than 3 characters
     */
    public function it_should_return_400_if_name_less_than_minimum_chars() {
        $this->new_mahasiswa['name'] = 'as';
        $this->exec();
        
        $this->assertResponseCode(400);
        $this->assertGreaterThan(0, count($this->output->data));
        $this->assertContains('at least 3 characters in length', $this->output->data->name);
    }

    /**
     * @test
     * @testdux it should return 400 if name more than 50 characters
     */
    public function it_should_return_400_if_name_more_than_maximum_chars() {
        $this->new_mahasiswa['name'] = $this->generate_string(52);
        $this->exec();
        
        $this->assertResponseCode(400);
        $this->assertGreaterThan(0, count($this->output->data));
        $this->assertContains('cannot exceed 50 characters in length', $this->output->data->name);
    }

    /**
     * @test
     * @testdux it should return 201 if success add data mahasiswa
     */
    public function it_should_return_201_if_success_add_mahasiswa() {
        $this->exec();
        
        $this->assertResponseCode(201);
        $this->assertGreaterThan(0, count($this->output->data));
        $this->assertEquals('success', $this->output->status);
        $this->assertIsInt($this->output->data->inserted_id);
    }

    /**
     * @testdox clear data mahasiswa
     */
    public static function tearDownAfterClass() {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate('mahasiswa');
    }
}
?>
