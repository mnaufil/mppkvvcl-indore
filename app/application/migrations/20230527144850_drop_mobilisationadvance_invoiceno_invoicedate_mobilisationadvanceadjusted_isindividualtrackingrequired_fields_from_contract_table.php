<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_mobilisationadvance_invoiceno_invoicedate_mobilisationadvanceadjusted_isindividualtrackingrequired_fields_from_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('contract', 'mobilisation_advance');
		$this->dbforge->drop_column('contract', 'invoice_no');
		$this->dbforge->drop_column('contract', 'invoice_date');
		$this->dbforge->drop_column('contract', 'mobilisation_advance_adjusted');
		$this->dbforge->drop_column('contract', 'is_individual_tracking_required');
	}

	public function down()
	{
		$field1 = array(
			'mobilisation_advance' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			)
		);

		$field2 = array(
			'invoice_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			)
		);

		$field3 = array(
			'invoice_date' => array(
				'type' => 'DATE',
				'null' => TRUE
			)
		);

		$field4 = array(
			'mobilisation_advance_adjusted' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			)
		);

		$field5 = array(
			'is_individual_tracking_required' => array(
				'type' => 'BIT',
				'null' => TRUE
			)
		);

		$this->dbforge->add_column('contract', $field1);
		$this->dbforge->add_column('contract', $field2);
		$this->dbforge->add_column('contract', $field3);
		$this->dbforge->add_column('contract', $field4);
		$this->dbforge->add_column('contract', $field5);
	}
}


?>