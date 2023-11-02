<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_password_modifieddate_fields_from_mst_user_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('mst_user', $fields);
	}

	public function down()
	{
		$fields = array(
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('mst_user', $fields);
	}
}

?>