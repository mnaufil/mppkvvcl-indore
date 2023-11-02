<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_physical_progress_activity_id_from_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'physical_progress_activity_id');
	}

	public function down()
	{
		$fields = array(
			'physical_progress_activity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'physical_progress_activity_observation_id'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}
}


?>