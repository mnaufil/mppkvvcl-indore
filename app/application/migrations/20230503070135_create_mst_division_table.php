<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_division_table extends CI_Migration
{	
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'division_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'division_name' => array(
				'type' => 'NVARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'circle_id' => array(
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
				//'constraint' => 10,
				'null' => FALSE
			),
			'modifiedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				//'constraint' => 10,
				'null' => TRUE
			),
			'deletedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				// 'constraint' => 10,
				'null' => TRUE
			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('division_id', TRUE);

		$this->dbforge->create_table('mst_division', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_division', TRUE);
	}
}
?>