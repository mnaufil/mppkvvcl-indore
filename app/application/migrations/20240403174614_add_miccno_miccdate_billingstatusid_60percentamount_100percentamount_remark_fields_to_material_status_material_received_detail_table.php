<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_miccno_miccdate_billingstatusid_60percentamount_100percentamount_remark_fields_to_material_status_material_received_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'micc_no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'received_date'
			),
			'micc_date' => array(
				'type' => 'DATE',
				'null' => TRUE,
				'after' => 'micc_no'
			),
			'billing_status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'micc_date'
			),
			'60_percent_amount' => array(
				'type' => 'DECIMAL',
				'constraint' => '18,2',
				'null' => TRUE,
				'after' => 'billing_status_id'
			),
			'100_percent_amount' => array(
				'type' => 'DECIMAL',
				'constraint' => '18,2',
				'null' => TRUE,
				'after' => '60_percent_amount'
			),
			'remark' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE,
				'after' => '100_percent_amount'
			)
		);

		$this->dbforge->add_column('material_status_material_received_detail', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('material_status_material_received_detail', 'micc_no');
		$this->dbforge->drop_column('material_status_material_received_detail', 'micc_date');
		$this->dbforge->drop_column('material_status_material_received_detail', 'billing_status_id');
		$this->dbforge->drop_column('material_status_material_received_detail', '60_percent_amount');
		$this->dbforge->drop_column('material_status_material_received_detail', '100_percent_amount');
		$this->dbforge->drop_column('material_status_material_received_detail', 'remark');
	}
}