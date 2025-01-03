<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_compliance_reject_flag_table extends CI_Migration
{	
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'compliance_reject_flag' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			), 
			'physical_progress_activity_observation_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			), 
			'ncr_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'flag_message' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,				
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
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('compliance_reject_flag', TRUE);

		$this->dbforge->create_table('compliance_reject_flag', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('compliance_reject_flag', TRUE);
	}
}
?>