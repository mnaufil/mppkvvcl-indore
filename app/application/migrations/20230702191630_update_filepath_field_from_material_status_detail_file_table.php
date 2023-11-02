<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_filepath_field_from_material_status_detail_file_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'file_path' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			) 
		);

		$this->dbforge->modify_column('material_status_detail_file', $fields);
	}

	public function down()
	{
		$fields = array(
			'file_path' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('material_status_detail_file', $fields);
	}
}


?>