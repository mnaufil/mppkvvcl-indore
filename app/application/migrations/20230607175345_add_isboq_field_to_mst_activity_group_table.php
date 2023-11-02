<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isboq_field_to_mst_activity_group_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'is_boq' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'name'
			)
		);

		$this->dbforge->add_column('mst_activity_group', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_activity_group', 'is_boq');
	}
}
?>