<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'login';
$route['default_controller'] = 'Login/login';
$route['404_override'] = 'Custom404';
$route['authorization_failed'] = 'AuthorizationFailure';
$route['translate_uri_dashes'] = FALSE;

/******** Migration scripts starts ***************/

$route['MigrationIndex'] = 'Migrate/index';
$route['createMigration'] = 'Migrate/CreateMigration';
$route['undoMigration'] = 'Migrate/undoMigration';
$route['undoMigration/(:num)'] = 'Migrate/undoMigration/$1';
$route['resetMigration'] = 'Migrate/resetMigration';

/******** Migration scripts ends ***************/


/******** Application code starts ***************/

$route['login'] = 'Login/login';
$route['forgot-password'] = 'Forgotpassword/forgotpassword';
$route['check-login'] = 'Login/checklogin';
$route['statistics'] = 'Dashboard/index';
$route['statistics-table'] = 'Dashboard/statstable';
$route['logout'] = 'Dashboard/logout';
$route['pert-chart'] = 'Dashboard/pertchart';
$route['progress'] = 'Dashboard/physicalachievement';
$route['getlocations/(:num)'] = 'Dashboard/getlocations/$1';
$route['getcircles/(:num)'] = 'Dashboard/getcircles/$1';
$route['getdivisions/(:num)'] = 'Dashboard/getdivisions/$1';
$route['getlocationsfilter/(:num)/(:any)/(:any)/(:any)'] = 'Dashboard/getlocationsfilter/$1/$2/$3/$4';
$route['statistics-popup/(:any)/(:any)'] = 'Dashboard/statisticspopup/$1/$2';
$route['changeweekmonthval/(:any)/(:any)/(:any)/(:any)'] = 'Dashboard/changeweekmonthval/$1/$2/$3/$4';
$route['getweekdate/(:any)/(:any)'] = 'Dashboard/getweekdate/$1/$2';
$route['formhtmltable'] = 'Dashboard/formhtmltable';
$route['weekdatedropdownload/(:any)/(:any)'] = 'Dashboard/weekdatedropdownload/$1/$2';
$route['showgraph/(:any)'] = 'Dashboard/showgraph/$1';


$route['progress/(:any)'] = 'Dashboard/physicalachievement/$1';
$route['financial'] = 'Dashboard/financialachievement';
$route['financial/(:any)'] = 'Dashboard/financialachievement/$1';
$route['verification'] = 'Dashboard/physicalVerification';
$route['verification/(:any)'] = 'Dashboard/physicalVerification/$1';
$route['get-feeders-list'] = 'Dashboard/getFeedersList';

/*Physical Progress Module*/
$route['physical-verification'] = 'PhysicalProgress/index';
$route['search-physical-progress-sheet'] = 'PhysicalProgress/searchSheet';
$route['add-physical-progress/(:any)/(:num)/(:num)/(:num)'] = 'PhysicalProgress/editSheet/$1/$2/$3/$4';
$route['save-observation'] = 'PhysicalProgress/saveObservation';
$route['delete-observation'] = 'PhysicalProgress/deleteObservation';
$route['check-observation-exists'] = 'PhysicalProgress/checkAppliedObservationsExists';
$route['delete-applied-observations'] = 'PhysicalProgress/deleteAllAppliedObservations';
$route['save-physical-progress'] = 'PhysicalProgress/saveSheet';
$route['get-activity-detail'] = 'PhysicalProgress/getActivityDetail';
$route['fetch-ncrID'] = 'PhysicalProgress/getLastNCRID';
$route['get-observation'] = 'PhysicalProgress/getObservation';
$route['get-sheet/(:any)/(:num)/(:num)/(:num)'] = 'PhysicalProgress/getSheetDataByDate/$1/$2/$3/$4';
$route['search-contractor-pp'] = 'PhysicalProgress/searchContractor';
$route['clear-physical-progress'] = 'PhysicalProgress/clearPhysicalProgress';
$route['mark-pp-reviewed-sheet-complete'] = 'PhysicalProgress/markReviewedSheetComplete';

/*NCR Review Module*/
$route['ncr-review'] = 'NCRReview/index';
$route['search-ncr-review'] = 'NCRReview/searchNCRReview';
$route['edit-ncr/(:num)'] = 'NCRReview/editNCR/$1';
$route['update-NCR-details'] = 'NCRReview/updateNCR';
$route['send-ncr-mail'] = 'NCRReview/sendNCREmail';

/*Physical Progress Review Module*/
$route['physical-verification-review'] = 'PhysicalProgressReview/index';
$route['search-physical-progress-review'] = 'PhysicalProgressReview/searchReviewSheet';

/*Material Status Module*/
$route['material-status'] = 'MaterialStatus/index';
$route['add-material-status'] = 'MaterialStatus/addMaterialStatus';
$route['search-material-status'] = 'MaterialStatus/searchMaterialStatus';
$route['view-material-status'] = 'MaterialStatus/viewMaterialStatus';
$route['edit-material-status/(:num)'] = 'MaterialStatus/editMaterialStatus/$1';
$route['save-material-status'] = 'MaterialStatus/saveMaterialStatus';
$route['search-contractor'] = 'MaterialStatus/searchContractor';
$route['get-materials'] = 'MaterialStatus/getMaterials';
$route['get-circles'] = 'MaterialStatus/getCircles';
$route['get-material-details'] = 'MaterialStatus/getMaterialDetails';
$route['get-material-quantity'] = 'MaterialStatus/getMaterialQuantity';
$route['save-material-details'] = 'MaterialStatus/saveMaterialDetails';
$route['update-material-details'] = 'MaterialStatus/updateMaterialDetails';
$route['get-inspecting-agencies'] = 'MaterialStatus/getInspectingAgencies';
$route['delete-material-status'] = 'MaterialStatus/deleteMaterialStatus';

/*Invoice Status Module*/
$route['invoice-status'] = 'InvoiceStatus/index';
$route['add-invoice'] = 'InvoiceStatus/viewAddInvoice';
$route['add-invoice-status'] = 'InvoiceStatus/addInvoiceStatus';
$route['search-invoice'] = 'InvoiceStatus/searchInvoice';
$route['edit-invoice/(:num)'] = 'InvoiceStatus/viewEditInvoice/$1';
$route['edit-invoice-status'] = 'InvoiceStatus/editInvoiceStatus';
$route['save-invoice'] = 'InvoiceStatus/saveInvoice';
$route['get-invoice/(:num)/(:num)'] = 'InvoiceStatus/getInvoice/$1/$2';
$route['view-invoice/(:num)'] = 'InvoiceStatus/viewInvoice/$1';

/*Reports Module*/
$route['reports'] = 'Report/index';
$route['view-report'] = 'Report/viewReport';
$route['generate-physical-report'] = 'Report/generatePhysicalReport';
$route['visit-report'] = 'Report/visitReport';
$route['generate-visit-report'] = 'Report/generateVisitReport';
$route['ncr-report'] = 'Report/ncrReport';
$route['generate-ncr-report'] = 'Report/generateNcrReport';
$route['export-excel-sp'] = 'Report/exportExcelSp';
$route['contract-summary-report'] = 'Report/contractSummaryReport';
$route['generate-contract-summary-report'] = 'Report/generateContractSummaryReport';
$route['bg-summary-report'] = 'Report/bgSummaryReport';
$route['generate-bg-summary-report'] = 'Report/generateBgSummaryReport';
$route['show-tkcs/(:num)'] = 'Report/showtkcs/$1';
$route['mobilisation-summary-report'] = 'Report/mobilisationSummaryReport';
$route['generate-mobilisation-summary-report'] = 'Report/generateMobilisationSummaryReport';
$route['non-conformance-report'] = 'Report/nonConformanceReport';
$route['generate-non-conformance-report'] = 'Report/generateNonConformaceReport';
$route['material-status-report'] = 'Report/materialStatusReport';
$route['generate-material-status-report'] = 'Report/generateMaterialStatusReport';
$route['material-status-summary'] = 'Report/materialStatusSummary';
$route['generate-material-status-summary'] = 'Report/generateMaterialStatusSummary';
$route['cash-flow-report'] = 'Report/cashFlowReport';
$route['generate-cash-flow-report'] = 'Report/generateCashFlowReport';
$route['invoicing-payment-report'] = 'Report/invoicingPaymentReport';
$route['generate-invoicing-payment-report'] = 'Report/generateInvoicingPaymentReport';
$route['convert-pdf'] = 'Report/convertPdf';
$route['show-feeders/(:num)'] = 'Report/showfeeders/$1';

/*TypeofWork Module*/
$route['typeofwork'] = 'Setup/worktype';
$route['add-typeofwork'] = 'Setup/addtypeofwork';
$route['edit-typeofwork'] = 'Setup/edittypeofwork';
$route['save-typeofwork'] = 'Setup/savetypeofwork';

/*TypeofWork-Activities Module*/
$route['typeofwork-activities'] = 'TypeofWorkActivities/index';
$route['add-activity/(:num)'] = 'TypeofWorkActivities/addActivity/$1';
$route['save-activity-group'] = 'TypeofWorkActivities/saveActivityGroup';
$route['save-activity'] = 'TypeofWorkActivities/saveTypeofWorkActivities';
$route['update-activity'] = 'TypeofWorkActivities/updateTypeofWorkActivities';
$route['delete-activity'] = 'TypeofWorkActivities/deleteTypeofWorkActivity';

$route['circle'] = 'Setup/divisions';
$route['loadmilestones/(:num)'] = 'Setup/loadmilestones/$1';
$route['loadregions/(:num)'] = 'Setup/loadregions/$1';
$route['loadcircle/(:num)/(:num)'] = 'Setup/loadcircle/$1/$2';
$route['loaddivision/(:num)/(:num)'] = 'Setup/loaddivision/$1/$2';
$route['loadsessioncircle/(:num)'] = 'Setup/loadsessioncircle/$1';
$route['loadsessiondivision/(:num)'] = 'Setup/loadsessiondivision/$1';

$route['checkquotedpricewithgst'] = 'Setup/checkquotedpricewithgst';
$route['checkquantity'] = 'Setup/checkquantity';
$route['loadunits/(:num)'] = 'Setup/loadunits/$1';
$route['loadmobilisationtype/(:num)'] = 'Setup/loadmobilisationtype/$1';
$route['checkquotedpricewithoutgst'] = 'Setup/checkquotedpricewithoutgst';
$route['loadbanktypes/(:num)'] = 'Setup/loadbanktypes/$1';
$route['contract-management'] = 'Setup/contractmanagement';
$route['contract-management/add'] = 'Setup/addcontractpage';
$route['contract-management/(:num)'] = 'Setup/editcontractpage/$1';
$route['view-contract-management/(:num)'] = 'Setup/viewcontractpage/$1';
$route['add-contract-management'] = 'Setup/addcontract';
$route['update-contract-management'] = 'Setup/updatecontract';

$route['delete-contract/(:num)'] = 'Setup/deletecontract/$1';
$route['typeofworkboq/(:num)'] = 'Setup/typeofworkboq/$1';
$route['typeofworkboqedit/(:num)/(:num)'] = 'Setup/typeofworkboqedit/$1/$2';
$route['checktypeofworkboq'] = 'Setup/checktypeofworkboq';
$route['saveboq'] = 'Setup/saveboq';
$route['saveboqedit'] = 'Setup/saveboqedit';

/*Setup / Region Module*/
$route['region'] = 'Region/index';
$route['add-region'] = 'Region/addRegion';
$route['save-region'] = 'Region/saveRegion';
$route['edit-region/(:num)'] = 'Region/editRegion/$1';
$route['update-region'] = 'Region/updateRegion';
$route['delete-region'] = 'Region/deleteRegion';

/*Setup / Circle Module*/
$route['circle'] = 'Circle/index';
$route['add-circle'] = 'Circle/addCircle';
$route['save-circle'] = 'Circle/saveCircle';
$route['search-circle'] = 'Circle/searchCircle';
$route['edit-circle/(:num)'] = 'Circle/editCircle/$1';
$route['update-circle'] = 'Circle/updateCircle';
$route['delete-circle'] = 'Circle/deleteCircle';

/*Setup / Division Module*/
$route['division'] = 'Division/index';
$route['search-division'] = 'Division/searchDivision';
$route['add-division'] = 'Division/addDivision';
$route['save-division'] = 'Division/saveDivision';
$route['edit-division/(:num)'] = 'Division/editDivision/$1';
$route['update-division'] = 'Division/updateDivision';
$route['delete-division'] = 'Division/deleteDivision';

/*TKC Weekly Plan*/
$route['tkc-weekly-plan'] = 'TKCWeeklyPlan/index';
$route['add-tkc-weekly-plan'] = 'TKCWeeklyPlan/addTKCWeeklyPlan';
$route['save-tkc-weekly-plan'] = 'TKCWeeklyPlan/saveTKCWeeklyPlan';
$route['get-feeders-list-tkc'] = 'TKCWeeklyPlan/getFeedersList';

/*TKC Physical Verification*/
$route['tkc-physical-verification'] = 'TKCPhysicalVerification/index';
$route['add-tkc-physical-verification/(:any)/(:num)/(:num)/(:num)'] = 'TKCPhysicalVerification/editSheet/$1/$2/$3/$4';
$route['save-tkc-physical-verification'] = 'TKCPhysicalVerification/saveSheet';

/*Security / Roles Module*/
$route['roles'] = 'Security/roles';
$route['add-role'] = 'Security/addRole';
$route['save-role'] = 'Security/saveRole';
$route['search-role'] = 'Security/searchRoles';
$route['edit-role/(:num)'] = 'Security/editRole/$1';
$route['update-role'] = 'Security/updateRole';
$route['delete-role'] = 'Security/deleteRole';

/*Security / User Module*/
$route['users'] = 'Security/users';
$route['users/add'] = 'Security/adduserspage';
$route['add-users'] = 'Security/addusers';
$route['users/(:num)'] = 'Security/edituserspage/$1';
$route['update-users'] = 'Security/updateusers';
$route['delete-user/(:num)'] = 'Security/deleteuser/$1';
$route['check-user-exists'] = 'Security/checkUserExists';

/*Change Password*/
$route['change-password'] = 'Security/viewChangePassword';
$route['save-change-password'] = 'Security/saveChangePassword';

$route['generatesession'] = 'Setsession/generatesession';
$route['viewsession'] = 'Setsession/viewsession';
$route['destroysession'] = 'Setsession/destroysession';
$route['checkcontractstagecount'] = 'Setup/checkcontractstagecount';
$route['checkrowboq/(:num)/(:num)/(:any)'] = 'Setup/checkrowboq/$1/$2/$3';
$route['checkdatelessthan/(:any)/(:num)/(:any)'] = 'Setup/checkdatelessthan/$1/$2/$3';


//$route['change-password'] = 'Security/changepassword';

/******** Application code starts ***************/


/******** Api Routes Start ***************/
$route['api/check-login'] = 'Api/checklogin';

/*Physical Verification API*/
$route['api/physical-progress'] = 'PhysicalProgressApi/index';
$route['api/get-sheet-details'] = 'PhysicalProgressApi/get_ppsheet_details';
$route['api/get-last-ncr-id'] = 'PhysicalProgressApi/get_last_ncr_id';
$route['api/get-observations'] = 'PhysicalProgressApi/get_observations';
$route['api/save-observations'] = 'PhysicalProgressApi/save_observations';
$route['api/update-observations'] = 'PhysicalProgressApi/update_observations';
$route['api/get-applied-observations-list'] = 'PhysicalProgressApi/get_applied_observations_list';
$route['api/get-applied-observations-details'] = 'PhysicalProgressApi/get_applied_observations_details';
$route['api/edit-applied-observation'] = 'PhysicalProgressApi/edit_applied_observation';
$route['api/delete-applied-observation'] = 'PhysicalProgressApi/delete_applied_observation';
$route['api/save-sheet-details'] = 'PhysicalProgressApi/save_ppsheet_details';
$route['api/get-prev-sheet-dates'] = 'PhysicalProgressApi/get_previous_sheet_dates';
$route['api/search-sheets'] = 'PhysicalProgressApi/search_sheets';
$route['api/filter-data'] = 'PhysicalProgressApi/filter_data';
$route['api/change-password'] = 'PhysicalProgressApi/change_password';

/*TKC Weekly Plan API*/
$route['api/tkc-weekly-plan-list'] = 'TKCWeeklyPlanApi/index';
$route['api/tkc-weekly-plan-filter'] = 'TKCWeeklyPlanApi/filter_data';
$route['api/tkc-weekly-plan-search'] = 'TKCWeeklyPlanApi/filter_weekly_plan';

/*TKC Physical Verification API*/
$route['api/tkc-physical-verification'] = 'TKCPhysicalVerificationApi/index';
$route['api/get-tkc-sheet-details'] = 'TKCPhysicalVerificationApi/get_tkc_ppsheet_details';
$route['api/save-tkc-sheet-details'] = 'TKCPhysicalVerificationApi/save_tkc_ppsheet_details';


/*PS Dashboard API*/
$route['api/authentication-token'] = 'PSDashboardApi/authenticateUser';
$route['api/get-physical-verification-data'] = 'PSDashboardApi/getFeedersData';
$route['api/update-feeders-data'] = 'PSDashboardApi/updateFeederData';


/******** Api Routes End ***************/



