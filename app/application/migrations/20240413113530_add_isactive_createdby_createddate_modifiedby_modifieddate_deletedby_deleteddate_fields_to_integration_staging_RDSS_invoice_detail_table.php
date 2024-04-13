<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isactive_createdby_createddate_modifiedby_modifieddate_deletedby_deleteddate_fields_to_integration_staging_RDSS_invoice_detail_table extends CI_Migration
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

		$this->dbforge->add_column('integration_staging_RDSS_invoice_detail', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'is_active');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'createdby');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'createddate');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'modifiedby');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'modifieddate');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'deletedby');
		$this->dbforge->drop_column('integration_staging_RDSS_invoice_detail', 'deleteddate');
	}
}