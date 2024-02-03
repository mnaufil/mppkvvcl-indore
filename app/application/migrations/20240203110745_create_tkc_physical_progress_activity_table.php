<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_tkc_physical_progress_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'tkc_physical_progress_activity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'tkc_physical_progress_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'sr_no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'activity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'unit_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'erected_qty' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => TRUE
			),
			'additional_erected_qty' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => TRUE
			),
			'remarks' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
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
				'null' => TRUE,
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('tkc_physical_progress_activity_id', TRUE);

		$this->dbforge->create_table('tkc_physical_progress_activity', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('tkc_physical_progress_activity', TRUE);
	}
}

?>