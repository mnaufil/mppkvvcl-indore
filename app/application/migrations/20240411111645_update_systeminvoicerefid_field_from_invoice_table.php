<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_systeminvoicerefid_field_from_invoice_table extends CI_Migration
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
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('invoice', $fields);
	}

	public function down()
	{
		$fields = array(
			'system_invoice_ref_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('invoice', $fields);
	}
}

?>