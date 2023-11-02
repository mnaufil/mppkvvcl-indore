<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_contractlocationid_activityid_fields_to_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contract_location_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'physical_progress_activity_observation_id'
			), 
			'activity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'contract_location_id'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'contract_location_id');
		$this->dbforge->drop_column('physical_progress_activity_observation', 'activity_id');
	}
}
?>