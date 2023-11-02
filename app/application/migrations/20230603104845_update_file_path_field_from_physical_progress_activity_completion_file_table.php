<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_file_path_field_from_physical_progress_activity_completion_file_table extends CI_Migration
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
				'constraint' => 200,
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('physical_progress_activity_completion_file', $fields);
	}

	public function down()
	{
		$fields = array(
			'file_path' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			)	
		);

		$this->dbforge->modify_column('physical_progress_activity_completion_file', $fields);
	}
}


?>