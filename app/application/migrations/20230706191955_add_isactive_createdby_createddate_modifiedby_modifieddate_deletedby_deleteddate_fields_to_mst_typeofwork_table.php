<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isactive_createdby_createddate_modifiedby_modifieddate_deletedby_deleteddate_fields_to_mst_typeofwork_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'is_individual_tracking'
			),
			'createdby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'is_active'
			),
			'createddate' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'after' => 'createdby'
			),
			'modifiedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'createddate'
			),
			'modifieddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'after' => 'modifiedby'
			),
			'deletedby' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'modifieddate'
			),
			'deleteddate' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'after' => 'deletedby'
			)
		);

		$this->dbforge->add_column('mst_typeofwork', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_typeofwork', 'is_active');
		$this->dbforge->drop_column('mst_typeofwork', 'createdby');
		$this->dbforge->drop_column('mst_typeofwork', 'createddate');
		$this->dbforge->drop_column('mst_typeofwork', 'modifiedby');
		$this->dbforge->drop_column('mst_typeofwork', 'modifieddate');
		$this->dbforge->drop_column('mst_typeofwork', 'deletedby');
		$this->dbforge->drop_column('mst_typeofwork', 'deleteddate');
	}
}
?>