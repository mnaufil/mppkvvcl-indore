<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_user_data_access_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'user_data_access_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'region_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'circle_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'division_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('user_data_access_id', TRUE);

		$this->dbforge->create_table('mst_user_data_access', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_user_data_access', TRUE);
	}
}

?>