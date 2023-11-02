<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_unit_id_field_to_mst_typeofwork_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'unit_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'activity_group_id'
			)
		);

		$this->dbforge->add_column('mst_typeofwork_activity', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_typeofwork_activity', 'unit_id');
	}
}
?>