<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_import_hdr_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'import_hdr_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'import_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'sub_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => FALSE
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'error_message' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'is_valid' => array(
				'type' => 'BIT',
				'null' => TRUE
			),
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE
			),
			'createdby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'createddate' => array(
				'type' => 'DATETIME',
				'null' => FALSE
			),
			'modifiedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'deletedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('import_hdr_id', TRUE);

		$this->dbforge->create_table('import_hdr', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('import_hdr', TRUE);
	}
}

?>