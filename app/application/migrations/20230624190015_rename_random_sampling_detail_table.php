<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Rename_random_sampling_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->rename_table('random_sampling_detail', 'material_status_random_sampling_detail');
	}

	public function down()
	{
		$this->dbforge->rename_table('material_status_random_sampling_detail', 'random_sampling_detail');
	}
}
?>