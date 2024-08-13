<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_raisedby_designation_distributioncentre_to_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'raised_by' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'after' => 'completion_date'
			),
			'designation' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'after' => 'raised_by'
			),
			'distribution_centre' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'after' => 'designation'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'raised_by');
		$this->dbforge->drop_column('physical_progress_activity_observation', 'designation');
		$this->dbforge->drop_column('physical_progress_activity_observation', 'distribution_centre');
	}
}
?>