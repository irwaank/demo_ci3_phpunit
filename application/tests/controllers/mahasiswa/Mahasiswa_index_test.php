<?php

/**
 * @author Irwan Kurniadi
 * @copyright 2020 - Irwan Kurniadi
 */
class Mahasiswa_index extends TestCase {
    
    /**
     * @testdox init mahasiswa with seeds 3 data
     */
     public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->setPath(APPPATH.'tests/database_seeds/');
        $CI->seeder->call('MahasiswaSeeder');
        self::assertTrue(true);
    }    

    /**
     * @testdox init library, object and variable
     */
     public function setUp() {
        $this->output = $this->request('GET', 'mahasiswa/index');
        $this->output = json_decode($this->output);
        $this->expected_mahasiswa = array(
            0 => 'Mifta',
            1 => 'Yahya',
            2 => 'Raina'
        );
        self::assertTrue(true);
    }

    /**
     * @testdox clear object and variable
     */    
     public function tearDown() {
        $this->output = NULL;        
    }    

    /**
     * @test
     * @testdox it should return 404 not found
     */
    public function it_should_return_404() {
		$this->request('GET', 'mahasiswa/method_not_exist');
		$this->assertResponseCode(404);
    }
    
    /**
     * @test
     * @testdox it should return an object
     * @group index_mahasiswa
     */    
     public function it_should_return_object() {
        // PHPUnit 7^
        #$this->assertIsObject($this->output);
        
        // PHPUnit 6^
        $this->assertEquals(TRUE, is_object($this->output));
    }    

    /**
     * @test
     * @testdox it should return data mahasiswa as expected
     */
    /*
     public function it_should_return_data_mahasiswa() {
        $this->assertEquals(count($this->expected_mahasiswa), count($this->output->data));        
        
        $length = count($this->expected_mahasiswa);
        for ($i = 0; $i < $length; $i++) {
            $this->assertEquals($this->expected_mahasiswa[$i], $this->output->data[$i]->name);
        }               
    }
    */

    /**
     * @testdox clear data mahasiswa
     */
    public static function tearDownAfterClass() {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate('mahasiswa');
        self::assertTrue(true);
    }
}
?>
