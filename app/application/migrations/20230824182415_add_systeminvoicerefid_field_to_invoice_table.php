<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_systeminvoicerefid_field_to_invoice_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'system_invoice_ref_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'balance_to_pay'
			)
		);

		$this->dbforge->add_column('invoice', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('invoice', 'system_invoice_ref_id');
	}
}
?>