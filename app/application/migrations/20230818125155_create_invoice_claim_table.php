<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_invoice_claim_table extends CI_Migration {

	public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }


  public function up()
  {
  	$fields = array(
      'invoice_claim_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'null' => FALSE
      ), 
      'invoice_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE
      ),
      'claim_type_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE
      ), 
      'claim_amount_with_gst' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => FALSE
      ), 
      'moblisation_adv_adjusted_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'ld_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'interest_on_moblisation_adv_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'other_deductions_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'tds_gsttds_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'payable_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
      ), 
      'balance_to_pay_amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '17,2',
        'null' => TRUE
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

    $this->dbforge->add_key('invoice_claim_id',TRUE);

    $this->dbforge->create_table('invoice_claim',TRUE); 
  }

  public function down()
  {
  	$this->dbforge->drop_table('invoice_claim', TRUE);
  }
}