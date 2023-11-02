<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_statusid_field_to_invoice_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'system_invoice_ref_id'
			)
		);

		$this->dbforge->add_column('invoice', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('invoice', 'status_id');
	}
}
?>