<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_role_report_access_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'role_report_access_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'role_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'report_access_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE	
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE		
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('role_report_access_id', TRUE);

		$this->dbforge->create_table('mst_role_report_access', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_role_report_access', TRUE);
	}
}

?>