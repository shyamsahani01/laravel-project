<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ErpAPIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\fieldscontroller;
use App\Http\Controllers\PFController;
use App\Http\Controllers\ESIController;
use App\Http\Controllers\FGreportsController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ESSLController;
use App\Http\Controllers\Jade\JadePowerBiController;
use App\Http\Controllers\Emporer\DesignController;
use App\Http\Controllers\Emporer\OrdersController;
use App\Http\Controllers\Emporer\BagController;
use App\Http\Controllers\Emporer\ParameterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Api Call In 21

Route::get('essl_erp', function () {
    \Artisan::call('Essl:Erp');
   // Session::flash('message', 'Attendnce Data Checkin Sussfully!');
   // Session::flash('alert-class', 'alert-success');
    return redirect()->route('AttendanceRecordEssl');
    //return "Attendnce Data Checkin Sussfully";
});


Route::get('api/delete-attendnce', [ApiController::class, 'deleteAttendnce'])->name('ApiAttendance');
Route::get('api/date-attendnce', [ApiController::class, 'dateAttendnce'])->name('ApiAttendance');


Route::get('api/attendnce-api', [ApiController::class, 'index'])->name('ApiAttendance');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/messagereply/{token}', [HomeController::class, 'MessageReplay'])->name('MessageReplay');
Route::POST('/messagereplaystore', [HomeController::class, 'messageReplayStore'])->name('messageReplayStore');
Route::get('/thankyou', [HomeController::class, 'Thankyou'])->name('home');
Route::get('/sendMessage', [HomeController::class, 'sendMessage'])->name('sendMessage');
Route::get('/emailverfiy/{$email}', [HomeController::class, 'emailVerfiy'])->name('emailVerfiy');

/**Vendor Message Chat*/
Route::get('/message/chat', [HomeController::class, 'viewMessageChat'])->name('messageChat');
Route::Post('/storemessagechat', [HomeController::class, 'ChatSingleMessage'])->name('ChatSingleMessage');

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout',[HomeController::class, 'logout'])->name('logout');
Route::POST('/messagesend', [HomeController::class, 'messageSend'])->name('messageSend');
Route::get('/view-message/{id}', [HomeController::class, 'ViewMessage'])->name('ViewMessage');
Route::POST('/chatmessage', [HomeController::class, 'ChatMessage'])->name('ChatMessage');
Route::get('/adminusers', [HomeController::class, 'adminUser'])->name('adminUser');
Route::get('/user-active/{id}', [HomeController::class, 'UserStatusUpdate'])->name('UserActive');
Route::get('/user-deleted/{id}', [HomeController::class, 'deleteUser'])->name('deleteUser');
Route::get('/addmore', [HomeController::class, 'addMore'])->name('addMore');

Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
Route::group(['middleware' => ['auth']], function () {
/** All Message */
Route::get('/message', [HomeController::class, 'allMessage'])->name('allMessage');
Route::get('/message/view-message/{token}', [HomeController::class, 'viewMessageReply'])->name('view-Message');

/** Single Message Chat */
Route::get('/message/{id}', [HomeController::class, 'viewMessageSingle'])->name('view-Message-single');
Route::Post('/storemessagechat', [HomeController::class, 'ChatSingleMessage'])->name('ChatSingleMessage');

/** File Import And Export Routes */
// Route::post('file-import', [App\Http\Controllers\UserController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');

/** Products Routes Add ,Edit,Delete  */
Route::get('add-product', [UserController::class, 'addProduct'])->name('add-product');
Route::post('storeProduct', [UserController::class, 'storeProduct'])->name('storeProduct');
Route::get('/product-deleted/{id}', [UserController::class, 'deleteProduct'])->name('deleteProduct');
Route::post('category-import', [UserController::class, 'CategoryImport'])->name('category-import');
/** User Route */
Route::get('add-user', [UserController::class, 'addUser'])->name('add-user');
Route::post('store-user', [UserController::class, 'StoreUser'])->name('user.store');
Route::get('edit-user/{id}', [UserController::class, 'editUser'])->name('edit-user');
Route::post('updateuser', [UserController::class, 'UpdateUser'])->name('user.update');
Route::get('delete-user/{id}', [UserController::class, 'deleteUser'])->name('delete-user');

/** Vendor List */

Route::get('vendor-list', [HomeController::class, 'vendorList'])->name('vendor-list');
Route::get('/adminusers', [HomeController::class, 'adminUser'])->name('adminUser');
Route::get('/employyecheck', [HomeController::class, 'EmployyeCheck'])->name('EmployyeCheck');

/**Erp Next Data Routes */

Route::get('/stockladger', [ErpAPIController::class, 'StockLedger'])->name('stockladeger');
Route::get('/purchaseorder', [ErpAPIController::class, 'PurchaseOrder'])->name('purchaseorder');
Route::get('/salesorder', [ErpAPIController::class, 'SalesOrder'])->name('salesorder');
Route::get('/puerchase/purchaserequest', [ErpAPIController::class, 'PurchaseRequest'])->name('purchaserequest');
Route::get('/item-montering', [ErpAPIController::class, 'ItemMontering'])->name('ItemMontering');
Route::get('/purchase-order/{code}', [ErpAPIController::class, 'StockPurchaseOrder'])->name('StockPurchaseOrder');
//Attendnce Route
Route::get('/attendance-data', [ErpAPIController::class, 'attendanceData'])->name('attendanceData');
Route::get('/attendance', [ErpAPIController::class, 'AttendanceRecord'])->name('attendanceData');
Route::get('/attendance-checkin-checkout', [ErpAPIController::class, 'AttendanceCheckin'])->name('attendanceData');

Route::get('/attendance/essl', [ErpAPIController::class, 'AttendanceRecordEssl'])->name('AttendanceRecordEssl');
Route::get('/employee-details/{slug}', [ErpAPIController::class, 'EmployeeDetails'])->name('EmployeeDetails');
// Route::get('/emp-attdata', [fieldscontroller::class, 'dailayrecords'])->name('dailayrecord');
Route::get('/emp-attdata', [fieldscontroller::class, 'dailayrecords'])->name('dailayrecord');



//Reports Route
Route::get('/reports', [ReportsController::class, 'index'])->name('report.index');
Route::get('/reports/purchase-reports', [ReportsController::class, 'PurchaseReport'])->name('report.index');
Route::get('/reports/sales-eports', [ReportsController::class, 'SalesReport'])->name('report.Sales');
Route::get('/reports/crm-reports', [ReportsController::class, 'StockReport'])->name('report.Stock');
Route::get('/reports/hr-reports', [ReportsController::class, 'HrReport'])->name('report.Hr');
Route::get('/reports/hr-reports-process', [ReportsController::class, 'HrReportInProcess'])->name('report.Hr');
//Route Export Data
Route::get('stocks-export', [ExportController::class, 'StocksExport'])->name('stock-export');
Route::get('attendnce-export', [ExportController::class, 'AttendnceExport'])->name('Attendance-export');
Route::get('out-missing-export', [ExportController::class, 'OutMisingExport'])->name('Outmissing-export');
Route::get('in-missing-export', [ExportController::class, 'INMisingExport'])->name('INMisingExport-export');
Route::get('checkin-export/{slug}', [ExportController::class, 'CheckInExport'])->name('Attendance-checkin-checkout-export');

Route::get('essl-export', [ExportController::class, 'EsslExport'])->name('Essl.Export');
//Ot Data Get
Route::get('ot-data-export', [ExportController::class, 'OvertimeExport'])->name('Overtime-export');

//Power Bi Slient Login
Route::get('powerbilogin', [HomeController::class, 'powerbilogin'])->name('powerbilogin');

Route::get('attendnce-record-api', [ErpAPIController::class, 'AttendnceRecordApi'])->name('AttendnceRecordApi');

Route::get('attendanceessl/export', [ExportController::class, 'AttendnceEsslExport'])->name('AttendnceEsslExport');
Route::get('attendnce-essl-export', [ExportController::class, 'EsslExportData'])->name('EsslExport');

Route::get('essl/export-overtimeview', [ExportController::class, 'EsslExportView'])->name('EsslExportView');
Route::get('attendanceessl/Overtimeexport', [ExportController::class, 'EsslOvertimeExport'])->name('EsslOvertimeExport');
//Google Speech
Route::get('google-speech', [ExportController::class, 'GoogleSpeech'])->name('GoogleSpeech');



Route::get('/markattendance', [ErpAPIController::class, 'MarkAttendanceCheckin'])->name('MarkAttendanceCheckin');



Route::get('pf/pf_challan', [PFController::class, 'pf_challan'])->name('pf.pf_challan');
Route::get('/pf/pf_challan/export', [PFController::class, 'pf_challan_export'])->name('pf.pf_challan_export');
Route::get('/pf/pf_challan/export_text', [PFController::class, 'pf_challan_export_text'])->name('pf.pf_challan_export_text');


Route::get('pf/pf_statement', [PFController::class, 'pf_statement'])->name('pf.pf_statement');
Route::get('/pf/pf_statement/export', [PFController::class, 'pf_statement_export'])->name('pf.pf_statement_export');


Route::get('esi/esi_challan', [ESIController::class, 'esi_challan'])->name('esi.esi_challan');
Route::get('esi/esi_statement', [ESIController::class, 'esi_statement'])->name('esi.esi_statement');

Route::get('/esi/esi_challan/export', [ESIController::class, 'esi_challan_export'])->name('esi.esi_challan_export');
Route::get('/esi/esi_statement/export', [ESIController::class, 'esi_statement_export'])->name('esi.esi_statement_export');

// Route::get('/fg/fgreports', [FGreportsController::class, 'fgreports'])->name('fg.fgreports');
// Route::get('/fg/unit1fgReport', [FGreportsController::class, 'unit1fgReport'])->name('fg.unit1fgReport');
// Route::get('/fg/unit2fgReport', [FGreportsController::class, 'unit1fgReport'])->name('fg.unit1fgReport');
// Route::get('/fg/unit1data', [FGreportsController::class, 'unit1data'])->name('fg.unit1data');
// Route::get('/fg/unit2data', [FGreportsController::class, 'unit2data'])->name('fg.unit2data');

Route::get('/fg/unit1/list', [FGreportsController::class, 'unit1fgReportList'])->name('fg.unit1fgReportList');
Route::get('/fg/unit1/details', [FGreportsController::class, 'unit1fgReportDetails'])->name('fg.unit1fgReportDetails');
Route::get('/fg/unit1/export', [FGreportsController::class, 'unit1fgReportExport'])->name('fg.unit1fgReportExport');
Route::get('/fg/unit2/list', [FGreportsController::class, 'unit2fgReportList'])->name('fg.unit2fgReportList');
Route::get('/fg/unit2/details', [FGreportsController::class, 'unit2fgReportDetails'])->name('fg.unit2fgReportDetails');
Route::get('/fg/unit2/export', [FGreportsController::class, 'unit2fgReportExport'])->name('fg.unit2fgReportExport');
Route::get('/fg/mahapura/list', [FGreportsController::class, 'mahapuraFGReportList'])->name('fg.mahapuraFGReportList');
Route::get('/fg/mahapura/details', [FGreportsController::class, 'mahapuraFGReportDetails'])->name('fg.mahapuraFGReportDetails');
Route::get('/fg/mahapura/export', [FGreportsController::class, 'mahapuraFGReportExport'])->name('fg.mahapuraFGReportExport');

Route::get('search-employee', [PFController::class, 'search_employee'])->name('pf.search_employee');

Route::get('quotation/list', [QuotationController::class, 'quotationList'])->name('quotation.quotationList');
Route::post('quotation/add', [QuotationController::class, 'quotationAdd'])->name('quotation.quotationAdd');
Route::get('quotation/delete', [QuotationController::class, 'quotationDelete'])->name('quotation.quotationDelete');

// Route::get('quotation/quotation_design_1/add', [QuotationController::class, 'quotationDesign1Add'])->name('quotation.quotationDesign1Add');
// Route::get('quotation/quotation_design_1/view', [QuotationController::class, 'quotationDesign1View'])->name('quotation.quotationDesign1View');
// Route::get('quotation/quotation_design_1/edit', [QuotationController::class, 'quotationDesign1Edit'])->name('quotation.quotationDesign1Edit');
// Route::get('quotation/quotation_design_1/export', [QuotationController::class, 'quotationDesign1Export'])->name('quotation.quotationDesign1Export');

Route::post('quotation/quotation_design_1/delete', [QuotationController::class, 'quotationDesign1Delete'])->name('quotation.quotationDesign1Delete');
Route::post('quotation/quotation_design_1/update', [QuotationController::class, 'quotationDesign1Update'])->name('quotation.quotationDesign1Update');
Route::post('quotation/quotation_design_1/addMoreData', [QuotationController::class, 'quotationDesign1AddMoreData'])->name('quotation.quotationDesign1AddMoreData');
Route::post('quotation/quotation_design_1/addMoreData2', [QuotationController::class, 'quotationDesign1AddMoreData2'])->name('quotation.quotationDesign1AddMoreData2');
Route::post('quotation/quotation_design_1/duplicateMoreData', [QuotationController::class, 'quotationDesign1DuplicateMoreData'])->name('quotation.quotationDesign1AddMoreData');
Route::post('quotation/quotation_design_1/addNewDesignFormRow', [QuotationController::class, 'quotationDesign1AddNewDesignFormRow'])->name('quotation.quotationDesign1AddNewDesignFormRow');
Route::post('quotation/quotation_design_1/duplicateNewDesignFormRow', [QuotationController::class, 'quotationDesign1DuplicateNewDesignFormRow'])->name('quotation.quotationDesign1DuplicateNewDesignFormRow');
Route::post('quotation/quotation_design_1/header_update', [QuotationController::class, 'quotationDesign1HeaderUpdate'])->name('quotation.quotationDesign1HeaderUpdate');
Route::post('quotation/quotation_design_1/performLabourCalculation', [QuotationController::class, 'performLabourCalculation'])->name('quotation.performLabourCalculation');
Route::post('quotation/quotation_design_1/performStoneCalculation', [QuotationController::class, 'performStoneCalculation'])->name('quotation.performStoneCalculation');

Route::post('quotation/get_3d_design_data', [QuotationController::class, 'get_3d_design_data'])->name('quotation.get_3d_design_data');
Route::post('quotation/get_2d_design_data', [QuotationController::class, 'get_2d_design_data'])->name('quotation.get_2d_design_data');
Route::post('quotation/getDesignImage', [QuotationController::class, 'getDesignImage'])->name('quotation.getDesignImage');

// Route::get('quotation/quotation_design_2/add', [QuotationController::class, 'quotationDesign2Add'])->name('quotation.quotationDesign2Add');
// Route::get('quotation/quotation_design_2/view', [QuotationController::class, 'quotationDesign2View'])->name('quotation.quotationDesign2View');
// Route::get('quotation/quotation_design_2/edit', [QuotationController::class, 'quotationDesign2Edit'])->name('quotation.quotationDesign2Edit');
// Route::get('quotation/quotation_design_2/export', [QuotationController::class, 'quotationDesign2Export'])->name('quotation.quotationDesign2Export');
Route::post('quotation/quotation_design_2/delete', [QuotationController::class, 'quotationDesign2Delete'])->name('quotation.quotationDesign2Delete');
Route::post('quotation/quotation_design_2/update', [QuotationController::class, 'quotationDesign2Update'])->name('quotation.quotationDesign2Update');
Route::post('quotation/quotation_design_2/header_update', [QuotationController::class, 'quotationDesign2HeaderUpdate'])->name('quotation.quotationDesign2HeaderUpdate');
Route::post('quotation/quotation_design_2/addMoreData', [QuotationController::class, 'quotationDesign2AddMoreData'])->name('quotation.quotationDesign2AddMoreData');
Route::post('quotation/quotation_design_2/duplicateMoreData', [QuotationController::class, 'quotationDesign2DuplicateMoreData'])->name('quotation.quotationDesign2DuplicateMoreData');
Route::post('quotation/quotation_design_2/addNewDesignFormRow', [QuotationController::class, 'quotationDesign2AddNewDesignFormRow'])->name('quotation.quotationDesign2AddNewDesignFormRow');
Route::post('quotation/quotation_design_2/duplicateNewDesignFormRow', [QuotationController::class, 'quotationDesign2DuplicateNewDesignFormRow'])->name('quotation.quotationDesign2DuplicateNewDesignFormRow');

Route::get('quotation/quotation_design/add', [QuotationController::class, 'quotationDesignAdd'])->name('quotation.quotationDesignAdd');
Route::get('quotation/quotation_design/view', [QuotationController::class, 'quotationDesignView'])->name('quotation.quotationDesignView');
Route::get('quotation/quotation_design/edit', [QuotationController::class, 'quotationDesignEdit'])->name('quotation.quotationDesignEdit');
Route::get('quotation/quotation_design/export', [QuotationController::class, 'quotationDesignExport'])->name('quotation.quotationDesignExport');

Route::get('hr/salary_register', [HRController::class, 'salary_register'])->name('hr.salary_register');
Route::get('/hr/salary_register/export', [HRController::class, 'salary_reg_export'])->name('hr.salary_reg_export');
Route::get('hr/employee_report', [HRController::class, 'employee_report'])->name('hr.employee_report');
Route::get('/hr/employee_report/emp_details', [HRController::class, 'empReportDetails'])->name('hr.emp_details');
Route::get('/hr/employee_attendance/emp_attendance_report', [HRController::class, 'empAttendanceReport'])->name('hr.empAttendanceReport');
Route::get('/hr/employee_attendance/emp_attendance_report/export', [HRController::class, 'employee_attendance_export'])->name('hr.employee_attendance_export');

// Route::get('/hr/employee_attendance/emp_attendance_report/export', [HRController::class, 'empAttendanceReportExport'])->name('hr.empAttendanceReportExport');

Route::get('/hr/emp_ot_lesshours/ot_lesshours_report', [HRController::class, 'ot_lesshours_report'])->name('hr.ot_lesshours_report');
Route::get('/hr/emp_ot_lesshours/ot_lesshours_report/export', [HRController::class, 'ot_lesshours_report_export'])->name('hr.ot_lesshours_report_export');
Route::post('/hr/emp_ot_lesshours/updateData', [HRController::class, 'ot_lesshours_update'])->name('hr.ot_lesshours_update');
Route::post('/hr/emp_ot_lesshours/getHTMLData', [HRController::class, 'ot_lesshours_getHTMLData'])->name('hr.ot_lesshours_getHTMLData');

Route::get('/hr/compliance_sheet', [HRController::class, 'compliance_sheet'])->name('hr.compliance_sheet');
Route::get('/hr/compliance_sheet/export', [HRController::class, 'compliance_sheet_export'])->name('hr.compliance_sheet_export');

Route::get('payroll/salary_com', [HRController::class, 'salary_com'])->name('payroll.salary_com');
Route::get('payroll/salary_com/export', [HRController::class, 'salary_component_export'])->name('payroll.salary_component_export');

Route::get('/hr/employee_report/emp_details/export', [HRController::class, 'employee_details_export'])->name('hr.employee_details_export');
Route::get('/hr/bonus_report', [HRController::class, 'bonus_report'])->name('hr.bonus_report');
Route::get('/hr/bonus_report/export', [HRController::class, 'bonus_report_export'])->name('hr.bonus_report_export');
Route::get('/hr/bank_sheet/hdfc_bank', [HRController::class, 'bank_sheet_hdfc_bank'])->name('hr.bank_sheet_hdfc_bank');
Route::get('/hr/bank_sheet/hdfc_bank/export', [HRController::class, 'bank_sheet_hdfc_bank_export'])->name('hr.bank_sheet_hdfc_bank_export');
Route::get('/hr/bank_sheet/other_bank', [HRController::class, 'bank_sheet_other_bank'])->name('hr.bank_sheet_other_bank');
Route::get('/hr/bank_sheet/other_bank/export', [HRController::class, 'bank_sheet_other_bank_export'])->name('hr.bank_sheet_other_bank_export');

Route::get('hr/salary_sheet', [HRController::class, 'salary_sheet'])->name('hr.salary_sheet');
Route::get('/hr/salary_sheet/export', [HRController::class, 'salary_sheet_export'])->name('hr.salary_sheet_export');

Route::get('hr/salary_sheet_accounts', [HRController::class, 'salary_sheet_accounts'])->name('hr.salary_sheet_accounts');
Route::get('/hr/salary_sheet_accounts/export', [HRController::class, 'salary_sheet_accounts_export'])->name('hr.salary_sheet_accounts_export');

Route::get('hr/leave_details', [HRController::class, 'leave_details'])->name('hr.leave_details');
Route::get('/hr/leave_details/export', [HRController::class, 'leave_details_export'])->name('hr.leave_details_export');

Route::get('getDataList', [QuotationController::class, 'getDataList'])->name('quotation.getCustomerNames');

Route::get('production/pd-orders/list', [ProductionController::class, 'ordersList'])->name('production.ordersList');
Route::get('production/pd-orders/view', [ProductionController::class, 'ordersDetails'])->name('production.ordersDetails');

Route::get('/jadePowerBiReport/list', [JadePowerBiController::class, 'list'])->name('JadePowerBi.list');
Route::get('/jadePowerBiReport/add', [JadePowerBiController::class, 'add'])->name('JadePowerBi.add');
Route::get('/jadePowerBiReport/delete', [JadePowerBiController::class, 'delete'])->name('JadePowerBi.delete');
Route::post('/jadePowerBiReport/add_data', [JadePowerBiController::class, 'add_data'])->name('JadePowerBi.add_data');


Route::get('/essl/essl_department/list', [ESSLController::class, 'essl_department_list'])->name('essl.essl_department_list');
Route::get('/essl/essl_employee/list', [ESSLController::class, 'essl_employee_list'])->name('essl.essl_employee_list');
Route::get('/essl/check_in_local/list', [ESSLController::class, 'check_in_local_list'])->name('essl.check_in_local_list');
Route::get('/essl/check_in_local/export', [ESSLController::class, 'check_in_local_export'])->name('essl.check_in_local_export');
Route::get('/essl/check_in_local/add', [ESSLController::class, 'check_in_local_add'])->name('essl.check_in_local_add');
Route::post('/essl/check_in_local/add', [ESSLController::class, 'check_in_local_add_data'])->name('essl.check_in_local_add_data');
Route::post('/essl/check_in_local/get_emp_details', [ESSLController::class, 'check_in_local_get_emp_details'])->name('essl.check_in_local_get_emp_details');


Route::get('/emporer/design/list', [DesignController::class, 'list'])->name('emporer.design.list');
Route::get('/emporer/design/designDetails', [DesignController::class, 'designDetails'])->name('emporer.design.designDetails');

Route::get('/emporer/orders/list', [OrdersController::class, 'list'])->name('emporer.orders.list');
Route::get('/emporer/orders/ordersDetails', [OrdersController::class, 'ordersDetails'])->name('emporer.orders.ordersDetails');
Route::get('/emporer/set-emrDB', [OrdersController::class, 'setEmrDB'])->name('setEmrDB');

Route::get('/emporer/bag/list', [BagController::class, 'list'])->name('emporer.bag.list');
Route::get('/emporer/bag/bagDetails', [BagController::class, 'bagDetails'])->name('emporer.bag.bagDetails');

Route::get('/emporer/transaction/list', [BagController::class, 'transactionList'])->name('emporer.bag.transaction');
Route::get('/emporer/transaction/transactionDetails', [BagController::class, 'transactionDetails'])->name('emporer.bag.transactionDetails');

Route::get('/emporer/parameter/list', [ParameterController::class, 'list'])->name('emporer.parameter.list');
Route::get('get-emr-parmeters', [ParameterController::class, 'getEmrParmeters'])->name('emporer.parameter.getEmrParmeters');
Route::get('/emporer/get-parameter-description', [ParameterController::class, 'getParameterDescription'])->name('getParameterDescription');

});
