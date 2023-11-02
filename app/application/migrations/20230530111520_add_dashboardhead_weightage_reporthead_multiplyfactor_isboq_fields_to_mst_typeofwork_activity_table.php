<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_dashboardhead_weightage_reporthead_multiplyfactor_isboq_fields_to_mst_typeofwork_activity_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'dashboard_head' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'after' => 'activity'
			),
			'weightage' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE,
				'after' => 'dashboard_head'
			),
			'report_head' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'after' => 'weightage'
			),
			'multiply_factor' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'after' => 'report_head'
			),
			'is_boq' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'multiply_factor'
			)
		);

		$this->dbforge->add_column('mst_typeofwork_activity', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('mst_typeofwork_activity', 'dashboard_head');
		$this->dbforge->drop_column('mst_typeofwork_activity', 'weightage');
		$this->dbforge->drop_column('mst_typeofwork_activity', 'report_head');
		$this->dbforge->drop_column('mst_typeofwork_activity', 'multiply_factor');
		$this->dbforge->drop_column('mst_typeofwork_activity', 'is_boq');
	}
}
?>