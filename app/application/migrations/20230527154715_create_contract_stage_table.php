<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_contract_stage_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contract_stage_id' => array(
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
			'stage_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			), 
			'date' => array(
				'type' => 'DATE',
				'null' => FALSE
			), 
			'quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '7,2',
				'null' => FALSE
			), 
			'amount' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
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

		$this->dbforge->add_key('contract_stage_id', TRUE);

		$this->dbforge->create_table('contract_stage', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('contract_stage', TRUE);
	}
}
?>