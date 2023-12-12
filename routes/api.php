<?php


// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: *');
// header('Access-Control-Allow-Headers: *');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WebController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\SMSController;
use App\Http\Controllers\API\EmailController;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\EnergyController;
use App\Http\Controllers\API\EMRController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('web/getUserDetails', [WebController::class, 'getUserDetails'])->name('getUserDetails');

Route::post('web/checkOrder', [WebController::class, 'checkOrder'])->name('checkOrder');
Route::post('web/getProductionWorkflowList', [WebController::class, 'getProductionWorkflowList'])->name('getProductionWorkflowList');
Route::post('web/getProductionWorkflowDetails', [WebController::class, 'getProductionWorkflowDetails'])->name('getProductionWorkflowDetails');
Route::post('web/updateProductionWorkflowBarcode', [WebController::class, 'updateProductionWorkflowBarcode'])->name('updateProductionWorkflowBarcode');
Route::post('web/updateProductionWorkflowWeight', [WebController::class, 'updateProductionWorkflowWeight'])->name('updateProductionWorkflowWeight');
Route::post('web/getItemsList', [WebController::class, 'getItemsList'])->name('getItemsList');
Route::post('web/addProductionWorkflowDetails', [WebController::class, 'addProductionWorkflowDetails'])->name('addProductionWorkflowDetails');
Route::post('web/getLastProductionWorkflowDetails', [WebController::class, 'getLastProductionWorkflowDetails'])->name('getLastProductionWorkflowDetails');
Route::post('web/checkBinLocation', [WebController::class, 'checkBinLocation'])->name('checkBinLocation');
Route::post('web/updateItemDetailsApi', [WebController::class, 'updateItemDetailsApi'])->name('updateItemDetailsApi');
Route::post('web/getUserAddedItemList', [WebController::class, 'getUserAddedItemList'])->name('getUserAddedItemList');
Route::post('web/getDesignInfo', [WebController::class, 'getDesignInfo'])->name('getDesignInfo');


Route::get('web/getImages', [WebController::class, 'getImages'])->name('getImages');

Route::get('test/employeeNewLeaveByJoining', [TestController::class, 'employeeNewLeaveByJoining'])->name('employeeNewLeaveByJoining');
Route::get('test/empLeaveMismatch', [TestController::class, 'empLeaveMismatch'])->name('empLeaveMismatch');
Route::get('test/empLeaveDetails', [TestController::class, 'empLeaveDetails'])->name('empLeaveDetails');
Route::get('test/testDataExport', [TestController::class, 'testDataExport'])->name('testDataExport');
Route::get('test/updateLeaveLeadgerBalance', [TestController::class, 'updateLeaveLeadgerBalance'])->name('updateLeaveLeadgerBalance');
Route::get('test/testFun', [TestController::class, 'testFun'])->name('testFun');

// Route::get('email/planningEmails', [EmailController::class, 'planningEmails'])->name('planningEmails')->middleware("cors");
Route::get('email/planningEmails', [EmailController::class, 'planningEmails'])->name('planningEmails');
Route::get('email/salarySlipEmails', [EmailController::class, 'salarySlipEmails'])->name('salarySlipEmails');

Route::get('email/salarySlipPDF', [EmailController::class, 'salarySlipPDF'])->name('salarySlipPDF');

Route::get('sms/employeeSalarySlip', [SMSController::class, 'employeeSalarySlip'])->name('employeeSalarySlip');
Route::get('sms/whatsappWebhook', [SMSController::class, 'whatsappWebhook'])->name('whatsappWebhook');
Route::get('sms/employeeSalarySlipWhatsapp', [SMSController::class, 'employeeSalarySlipWhatsapp'])->name('employeeSalarySlipWhatsapp');


Route::get('attendance/getEmployeeAttendance', [AttendanceController::class, 'getEmployeeAttendance'])->name('attendance.getEmployeeAttendance');
Route::get('attendance/getEmployeeMarkAttendance', [AttendanceController::class, 'getEmployeeMarkAttendance'])->name('attendance.getEmployeeMarkAttendance');
Route::get('attendance/updateLeaveBalance', [AttendanceController::class, 'updateLeaveBalance'])->name('attendance.updateLeaveBalance');

Route::get('webapi/update_production_workflow_tree', [ApiController::class, 'update_production_workflow_tree'])->name('update_production_workflow_tree');
// Route::get('webapi/getBomDetails', [ApiController::class, 'getBomDetails'])->name('getBomDetails')->middleware("cors");
Route::get('webapi/getBomDetails', [ApiController::class, 'getBomDetails'])->name('getBomDetails');
// Route::get('webapi/getBomDetailsExcel', [ApiController::class, 'getBomDetailsExcel'])->name('getBomDetailsExcel')->middleware("cors");
Route::get('webapi/getBomDetailsExcel', [ApiController::class, 'getBomDetailsExcel'])->name('getBomDetailsExcel');
// Route::get('webapi/get_last_po_item', [ApiController::class, 'get_last_po_item'])->name('get_last_po_item')->middleware("cors");
Route::get('webapi/get_last_po_item', [ApiController::class, 'get_last_po_item'])->name('get_last_po_item');
Route::get('webapi/get-job-opening', [ApiController::class, 'getJobOpening'])->name('getJobOpening');
Route::get('webapi/get-job-opening-details', [ApiController::class, 'getJobOpeningDetails'])->name('getJobOpeningDetails');

Route::get('energy/getwaterReading', [EnergyController::class, 'getwaterReading'])->name('getwaterReading');

Route::get('emr/update_design_bom_details', [EMRController::class, 'update_design_bom_details'])->name('update_design_bom_details');
Route::get('emr/update_design_details', [EMRController::class, 'getEMRDesigns'])->name('getEMRDesigns');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
