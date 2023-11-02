<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_observation_id_field_from_physical_progress_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('physical_progress_activity', 'observation_id');
	}

	public function down()
	{
		$fields = array(
			'observation_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'status_id'
			)
		);

		$this->dbforge->add_column('physical_progress_activity', $fields);
	}
}


?>