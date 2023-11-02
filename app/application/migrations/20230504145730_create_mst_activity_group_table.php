<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_activity_group_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'activity_group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('activity_group_id', TRUE);

		$this->dbforge->create_table('mst_activity_group', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_activity_group', TRUE);
	}
}

?>