<?php

/**
 * @author Irwan Kurniadi
 * @copyright 2020 - Irwan Kurniadi
 */
class M_mahasiswa_test extends TestCase {
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
        $this->resetInstance();
        $this->CI->load->model('M_mahasiswa');
        $this->model = $this->CI->M_mahasiswa;
        $this->where = array('id' => 1);
        $this->output = NULL;
        
        $this->expected_mahasiswa = array(
            1 => 'Mifta',
            2 => 'Yahya',
            3 => 'Raina'
        );
        $this->new_mahasiswa = array('name' => 'Irwan');
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
     * @testdox it should return num of rows mahasiswa's data
     */
    public function it_should_return_total_records() {
        $this->output = $this->model->countAll();

        $this->assertEquals(count($this->expected_mahasiswa), $this->output);
    }

    /**
     * @test
     * @testdox it should return all mahasiswa data
     */
    public function it_should_return_all_data_mahasiswa() {
        $count_expected = count($this->expected_mahasiswa);
        $this->output = $this->model->fetchAll();
        
        $this->assertCount($count_expected, $this->output);
        foreach($this->output as $r):
            $this->assertEquals($this->expected_mahasiswa[$r->id], $r->name);
        endforeach;
    }

    /**
     * @tets
     * @testdox it should return single mahasiswa data
     */
    public function it_should_return_single_data() {
        $this->output = $this->model->fetchSelected($this->where);

        $this->assertEquals(1, count($this->output));
        $this->assertEquals($this->expected_mahasiswa[1], $this->output->name);
    }

    /**
     * @test
     * @testdox it should return a new data mahasiswa
     */
    public function it_should_return_a_new_data() {
        $before_count = $this->model->countAll();
        $this->output = $this->model->insert($this->new_mahasiswa);
        
        $this->where['id'] = $this->output;
        $new_data = $this->model->fetchSelected($this->where);
        $after_count = $this->model->countAll();

        $this->assertEquals(TRUE, is_int($this->output));
        $this->assertEquals(($before_count + 1), $after_count);
        $this->assertEquals($this->new_mahasiswa['name'], $new_data->name);
    }

    /**
     * @test
     * @testdox it should return an updated data mahasiswa
     */
    public function it_should_return_an_updated_data() {
        $this->output = $this->model->update($this->where, $this->new_mahasiswa);
        $updated_data = $this->model->fetchSelected($this->where);

        $this->assertEquals(1, $this->output);
        $this->assertEquals($this->new_mahasiswa['name'], $updated_data->name);
    }

    /**
     * @test
     * @testdox it should delete a data mahasiswa
     */
    public function it_should_delete_data() {
        $before_count = $this->model->countAll();        
        $this->model->delete($this->where);
        $after_count = $this->model->countAll();
        
        $this->assertEquals(($before_count - 1), $after_count);
    }

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