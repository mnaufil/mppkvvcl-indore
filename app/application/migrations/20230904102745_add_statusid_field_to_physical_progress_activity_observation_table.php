<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_statusid_field_to_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'completion_date'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'status_id');
	}
}
?>