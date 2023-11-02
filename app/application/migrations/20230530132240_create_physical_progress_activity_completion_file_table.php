<?php   defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_physical_progress_activity_completion_file_table extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'physical_progress_activity_completion_file_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE
            ), 
            'physical_progress_activity_observation_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ), 
            'file_path' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ), 
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

        $this->dbforge->add_field($fields);

        $this->dbforge->add_key('physical_progress_activity_completion_file_id', TRUE);

        $this->dbforge->create_table('physical_progress_activity_completion_file', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('physical_progress_activity_completion_file', TRUE);
    }
}



?>