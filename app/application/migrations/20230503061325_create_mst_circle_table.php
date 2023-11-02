<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_circle_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'circle_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'circle_name' => array(
				'type' => 'NVARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'region_id' => array(
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

		$this->dbforge->add_key('circle_id', TRUE);

		$this->dbforge->create_table('mst_circle', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('mst_circle', TRUE);
	}
}
?>