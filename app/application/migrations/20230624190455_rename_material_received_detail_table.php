<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Rename_material_received_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->rename_table('material_received_detail', 'material_status_material_received_detail');
	}

	public function down()
	{
		$this->dbforge->rename_table('material_status_material_received_detail', 'material_received_detail');
	}
}
?>