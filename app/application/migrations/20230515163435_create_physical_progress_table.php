<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'physical_progress_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'contract_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'contract_location_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'site_location' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			),
			'reported_by' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'reported_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'remark' => array(
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
				'null' => TRUE
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('physical_progress_id', TRUE);

		$this->dbforge->create_table('physical_progress', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('physical_progress', TRUE);
	}
}

?>