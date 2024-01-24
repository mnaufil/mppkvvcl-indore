<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_tkc_plan_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'tkc_plan_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'from_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'to_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
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

		$this->dbforge->add_key('tkc_plan_id', TRUE);

		$this->dbforge->create_table('tkc_plan', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('tkc_plan', TRUE);
	}
}
?>