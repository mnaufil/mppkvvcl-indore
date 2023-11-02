<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_lastemaildetails_field_to_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'last_email_details' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'after' => 'completion_date'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'last_email_details');
	}
}
?>