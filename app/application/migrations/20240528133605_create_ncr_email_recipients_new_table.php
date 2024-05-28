<?php   defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_ncr_email_recipients_new_table extends CI_Migration
{
  function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }

  public function up()
  {
    $fields = array(
      'ncr_email_recipients_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ),
      'contract_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE
      ),
      'region_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE
      ),
      'circle_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE,
      ),
      'division_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE,
      ),
      'tkc_emails' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE,
      ),
      'fe_fs_emails' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE,
      ),
      'dtl_emails' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE,
      ),
      'client_emails' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE,
      ),
      'sgs_emails' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE,
      )
    );

    $this->dbforge->add_field($fields);

    $this->dbforge->add_key('ncr_email_recipients_id', TRUE);

    $this->dbforge->create_table('ncr_email_recipients_new', TRUE);
  }

  public function down()
  {
    $this->dbforge->drop_table('ncr_email_recipients_new', TRUE);
  }
}

?>