<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_status_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'module_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'name' => array(
				'type' => 'NVARCHAR',
				'constraint' => 100,
				'null' => FALSE	
			),
			'seqno' => array(
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

		$this->dbforge->add_key('status_id', TRUE);

		$this->dbforge->create_table('mst_status', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_status', TRUE);
	}
}



?>