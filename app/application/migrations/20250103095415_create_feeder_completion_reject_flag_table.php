<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_feeder_completion_reject_flag_table extends CI_Migration
{	
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'feeder_completion_reject_flag_id' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'feeder_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			), 
			'physical_progress_id' => array(
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

		$this->dbforge->add_key('feeder_completion_reject_flag_id', TRUE);

		$this->dbforge->create_table('feeder_completion_reject_flag', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('feeder_completion_reject_flag', TRUE);
	}
}
?>