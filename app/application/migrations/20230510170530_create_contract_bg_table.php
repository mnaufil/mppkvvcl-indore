<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_contract_bg_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contract_bg_id' => array(
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
			'sr_no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'bg_type_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'bg_number' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'bg_date' => array(
				'type' => 'DATE',
				'null' => TRUE
			),
			'bg_amount' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'bg_valid_till' => array(
				'type' => 'DATE',
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

		$this->dbforge->add_key('contract_bg_id', TRUE);

		$this->dbforge->create_table('contract_bg', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('contract_bg', TRUE);
	}
}

?>