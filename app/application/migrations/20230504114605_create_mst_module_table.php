<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_module_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'module_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'parent_module_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'icon' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('module_id', TRUE);

		$this->dbforge->create_table('mst_module', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_module', TRUE);
	}
}

?>