<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_remarkbytkc_to_physical_progress_activity_observation_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'remark_by_tkc' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE,
				'after' => 'observation_remark'
			)
		);

		$this->dbforge->add_column('physical_progress_activity_observation', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress_activity_observation', 'remark_by_tkc');
	}
}
?>