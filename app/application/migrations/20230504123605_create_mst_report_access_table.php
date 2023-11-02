<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_report_access_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'report_access_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'report_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'access_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE	
			),
			'event' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE	
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE		
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('report_access_id', TRUE);

		$this->dbforge->create_table('mst_report_access', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_report_access', TRUE);
	}
}

?>