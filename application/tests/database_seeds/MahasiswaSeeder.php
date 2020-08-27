<?php
/**
 *
 * @author     Irwan
 * @copyright  2020 - Irwan
 */

class MahasiswaSeeder extends CI_Seeder {

	private $table = 'mahasiswa';

	public function run()
	{
		$this->db->truncate($this->table);

		$data = [
			'id' => 1,
			'name' => 'Mifta',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 2,
			'name' => 'Yahya',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 3,
			'name' => 'Raina',
		];
		$this->db->insert($this->table, $data);
	}

}
