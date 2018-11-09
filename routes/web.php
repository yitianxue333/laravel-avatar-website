<?php
use Illuminate\Http\Request;
// use Session;
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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'permission.limitedworker'])->group(function() {
	Route::get('home', function() {
		return redirect('dashboard/index');
	});

	Route::get('dashboard/setting/change_password_view', 'DashboardController@change_password_view');
	Route::post('dashboard/setting/change_password', 'DashboardController@change_password')->name('change-password');

	Route::get('dashboard/getting-started', function() {
		return view('dashboard/gettingstart');
	});

	Route::get('logout', 'Auth/LoginController@logout');
	Route::get('dashboard/calendar', 'CalendarController@index')->name('Calendar.index');
	Route::get('dashboard/calendar/month', 'CalendarController@index');
	Route::post('dashboard/calendar/month/selectjob', 'CalendarController@getteammembers');
	Route::get('dashboard/calendar/week', 'CalendarController@week')->name('Calendar.week');
	Route::get('dashboard/calendar/map', 'CalendarController@map')->name('Calendar.map');
	Route::get('dashboard/calendar/map/{change_date}', 'CalendarController@map');
	Route::get('dashboard/calendar/events', 'CalendarController@events');
	Route::get('dashboard/calendar/delete_events', 'CalendarController@delete_events');
	Route::get('dashboard/calendar/event_completed','CalendarController@insert_complete');
	Route::get('dashboard/calendar/event_uncompleted','CalendarController@cancel_complete');
	Route::get('dashboard/calendar/grid_get_events','CalendarController@grid_get_events');
	Route::get('dashboard/calendar/grid_get_members','CalendarController@grid_get_members');
	Route::get('dashboard/calendar/grid', 'CalendarController@grid')->name('Calendar.grid');
	Route::get('dashboard/calendar/grid_assign_job','CalendarController@grid_assign_job');
	Route::get('dashboard/calendar/grid_drag','CalendarController@grid_drag');
	Route::get('dashboard/calendar/assign','CalendarController@grid_assign');
	Route::get('dashboard/calendar/task_edit_result','CalendarController@task_edit_pass');
	Route::get('dashboard/calendar/event_edit_result','CalendarController@event_edit_pass');
	Route::post('dashboard/calendar/map/gettrackpositions','CalendarController@get_track_positions');

	Route::post('dashboard/calendar/month/task','CalendarController@add_task')->name('Calendar.addtask');
	Route::post('dashboard/calendar/month', 'CalendarController@add_event')->name('Calendar.add');
	Route::post('dashboard/calendar/month/edit', 'CalendarController@edit_event')->name('Calendar.edit');
	Route::get('dashboard/calendar/list/detail', 'CalendarController@list_detail');
	Route::get('dashboard/calendar/list/completed_visit', 'CalendarController@list_complete_manage');
	Route::get('dashboard/calendar/list', 'CalendarController@list_calendar')->name('Calendar.list');
	Route::get('dashboard/calendar/detail_service', 'CalendarController@get_detail_service');
  
});

Route::middleware(['auth', 'permission.worker'])->group(function() {
	Route::get('dashboard', 'DashboardController@index');
	Route::get('dashboard/index', 'DashboardController@index');

	Route::get('dashboard/work', 'WorkController@index');
	Route::get('dashboard/work/overview', 'WorkController@index');
	
	Route::get('dashboard/work/jobs', 'JobsController@index');
	Route::post('dashboard/work/jobs/getJobs', 'JobsController@getJobs');	
	Route::get('dashboard/work/jobs/{id}/view', 'JobsController@view');
	Route::post('dashboard/work/jobs/getTimesheet', 'JobsController@getTimesheet');
	Route::post('dashboard/work/jobs/getReminder', 'JobsController@getReminder');	
	Route::post('dashboard/work/jobs/getVisit', 'JobsController@getVisit');
	Route::get('dashboard/work/jobs/generate-pdf/{id}', 'JobsController@pdfview')->name('generate-pdf');
	
	Route::get('dashboard/work/quotes', 'QuotesController@index');
	Route::get('dashboard/work/quotes/info/{quote_id}', 'QuotesController@info');
	Route::get('dashboard/work/quotes/add/{client_id}/{property_id}', 'QuotesController@add');
	Route::get('dashboard/work/quotes/add/{client_id}', 'QuotesController@add');
	Route::get('dashboard/work/quotes/newquote/{client_id}', 'QuotesController@newquote');
	Route::get('dashboard/work/quotes/edit/{quote_id}', 'QuotesController@edit');
	Route::get('dashboard/work/quotes/{quote_id}/mark_as', 'QuotesController@updatestatus');
	Route::get('dashboard/work/quotes/delete/{quote_id}', 'QuotesController@delete');
	Route::get('dashboard/work/quotes/generate-pdf/{id}', 'QuotesController@pdfview');
	Route::post('dashboard/work/quotes/sendmail', 'QuotesController@sendmail');
	Route::post('dashboard/work/quotes/insert', 'QuotesController@insert');
	Route::post('dashboard/work/quotes/update', 'QuotesController@update');
	Route::post('dashboard/work/quotes/savenotes', 'QuotesController@savenotes');
	Route::post('dashboard/work/quotes/delservice', 'QuotesController@delservice');
	Route::post('dashboard/work/quotes/{quote_id}/updatedeposit', 'QuotesController@updatedeposit');
	Route::post('dashboard/work/quotes/attachment', 'QuotesController@attachment');
	Route::post('dashboard/work/quotes/upload', 'QuotesController@upload');
	Route::post('dashboard/work/quotes/attachmentupdate','QuotesController@attachmentupdate')->name('quotes.attachment.update');
	
	Route::post('dashboard/work/createtax', 'QuotesController@createtax');

	Route::get('dashboard/timesheet', 'TimesheetController@index');
	Route::get('dashboard/timesheet/today', 'TimesheetController@index');
	Route::get('dashboard/timesheet/week', 'TimesheetController@week');
	Route::get('dashboard/timesheet/today/save', 'TimesheetController@today_timesheet_save');
	Route::get('dashboard/timesheet/today/edit', 'TimesheetController@today_timesheet_edit');
	Route::get('dashboard/timesheet/today/delete', 'TimesheetController@today_timesheet_delete');
	Route::get('dashboard/timesheet/week/update', 'TimesheetController@week_update');
	Route::get('dashboard/timesheet/week/{senddate}', 'TimesheetController@week');
	Route::get('dashboard/timesheet/today/{user}', 'TimesheetController@index');

	Route::get('dashboard/clients', 'ClientsController@index')->name('clients');
	Route::get('dashboard/clients/add', 'ClientsController@add')->name('clients.add');
	Route::get('dashboard/clients/detail/{client_id}', 'ClientsController@showdetailinfo');
	Route::get('dashboard/clients/newclient', 'ClientsController@newclient');
	Route::post('dashboard/clients/create', 'ClientsController@create')->name('clients.create');
	Route::get('dashboard/clients/updateview/{client_id}' , 'ClientsController@updateview');
	Route::post('dashboard/clients/update/{client_id}', 'ClientsController@update')->name('client.update');
	Route::post('dashboard/clients/detail/addtag', 'ClientsController@addtag');
	Route::post('dashboard/clients/detail/deletetag', 'ClientsController@deletetag');
	Route::post('dashboard/clients/detail/attachment', 'ClientsController@attachment')->name('client.attachment');
	Route::post('dashboard/clients/detail/upload', 'ClientsController@upload');
	Route::post('dashboard/clients/detail/attachmentupdate','ClientsController@attachmentupdate')->name('attachment.update');
	Route::post('dashboard/clients/detail/billing', 'ClientsController@billing');
	Route::post('dashboard/clients/detail/payment/save', 'ClientsController@paymentsave');
	Route::post('dashboard/clients/detail/paymentnew', 'ClientsController@paymentnew');
	Route::post('dashboard/clients/detail/visitview', 'ClientsController@visitview');
	Route::post('dashboard/clients/detail/payment/update', 'ClientsController@paymentupdate');
	Route::post('dashboard/clients/detail/task-complete', 'ClientsController@taskcomplete');
	Route::post('dashboard/clients/detail/getvisit', 'ClientsController@getvisit');
	Route::post('dashboard/clients/detail/payment/sendemail', 'ClientsController@sendemail');
	Route::post('dashboard/clients/detail/taskview', 'ClientsController@taskview');
	Route::post('dashboard/clients/detail/task/delete', 'ClientsController@task_delete');
	Route::post('dashboard/clients/detail/task/update','ClientsController@update_task')->name('client.updatetask');
	Route::post('dashboard/clients/detail/task/edit', 'ClientsController@task_edit');
	Route::post('dashboard/clients/detail/event/complete', 'ClientsController@complete_event');
	Route::post('dashboard/clients/detail/event/view', 'ClientsController@view_event');
	Route::post('dashboard/clients/detail/event/delete', 'ClientsController@delete_event');
	Route::post('dashboard/clients/detail/event/edit', 'ClientsController@edit_event');
	Route::post('dashboard/clients/detail/event/update', 'ClientsController@update_event')->name('client.update.event');
	Route::get('dashboard/clients/detail/get-pdf/{client_id}', 'ClientsController@pdfview');
	
	Route::get('dashboard/properties/manually_geocode/{property_id}', 'PropertyController@map');
	Route::get('dashboard/properties/location/{property_id}', 'PropertyController@location');
	Route::post('dashboard/properties/location/save/{property_id}', 'PropertyController@savelatlng')->name('location.save');
	Route::get('dashboard/properties', 'PropertyController@index')->name('properties');
	Route::get('dashboard/properties/detail/{property_id}', 'PropertyController@showdetailinfo');
	Route::get('dashboard/properties/newproperty/{client_id}', 'PropertyController@newproperty');
	Route::post('dashboard/properties/update/{property_id}', 'PropertyController@update')->name('properties.update');
	Route::get('dashboard/properties/updateview/{property_id}' , 'PropertyController@updateview');
	Route::post('dashboard/properties/create', 'PropertyController@create')->name('properties.create');
	Route::post('dashboard/properties/detail/task/update','PropertyController@update_task')->name('property.updatetask');
});

Route::middleware(['auth', 'permission.dispatcher'])->group(function() {
	Route::get('dashboard/work/jobs/new', 'JobsController@add');
	Route::get('dashboard/work/jobs/new/{date}', 'JobsController@add');
	Route::get('dashboard/work/jobs/edit/{id}', 'JobsController@edit');
	Route::get('dashboard/work/jobs/delete/{id}', 'JobsController@delete');
	Route::post('dashboard/work/jobs/deleteReminder/', 'JobsController@deleteReminder');
	Route::post('dashboard/work/jobs/visit-delete', 'JobsController@visitDelete');
	Route::post('dashboard/work/jobs/before-close', 'JobsController@beforeClose');
	Route::post('dashboard/work/jobs/close-job', 'JobsController@closeJob');
	Route::post('dashboard/work/jobs/reopen-job', 'JobsController@reopenJob');
	Route::post('dashboard/work/jobs/update', 'JobsController@update');
	Route::post('dashboard/work/jobs/getproperty/', 'JobsController@getProperty');
	Route::post('dashboard/work/jobs/select-property/', 'JobsController@selectProperty');
	Route::post('dashboard/work/jobs/new-job', 'JobsController@addNewJob');
	Route::post('dashboard/work/jobs/service/delete', 'JobsController@delete_service');
	Route::post('dashboard/work/jobs/attache', 'JobsController@attache');
	Route::post('dashboard/work/jobs/invoice_reminder', 'JobsController@invoice_reminder');
	Route::post('dashboard/work/jobs/visit-complete', 'JobsController@visitComplete');
	Route::post('dashboard/work/jobs/visit-service-delete', 'JobsController@visit_service_Delete');
	Route::post('dashboard/work/jobs/visit-save', 'JobsController@visitSave');
	Route::post('dashboard/work/jobs/note-save', 'JobsController@noteSave');

	Route::get('dashboard/work/invoices', 'InvoicesController@index');
	Route::get('dashboard/work/invoices/info/{invoice_id}', 'InvoicesController@info');
	Route::get('dashboard/work/invoices/add/{client_id}/', 'InvoicesController@add');
	Route::get('dashboard/work/invoices/newinvoice/{client_id}', 'InvoicesController@newinvoice');
	Route::get('dashboard/work/invoices/edit/{invoice_id}', 'InvoicesController@edit');
	Route::get('dashboard/work/invoices/delete/{invoice_id}', 'InvoicesController@delete');
	Route::get('dashboard/work/invoices/{invoice_id}/mark_as', 'InvoicesController@updatestatus');
	Route::get('dashboard/work/invoices/generate-pdf/{id}', 'InvoicesController@pdfview');
	Route::post('dashboard/work/invoices/sendmail', 'InvoicesController@sendmail');
	Route::post('dashboard/work/invoices/sendpaymail', 'InvoicesController@sendpaymail');
	Route::get('dashboard/work/invoices/generate-pdf/{id}', 'InvoicesController@pdfview');
	Route::post('dashboard/work/invoices/update', 'InvoicesController@update');
	Route::post('dashboard/work/invoices/getselectjob', 'InvoicesController@getselectjob');
	Route::post('dashboard/work/invoices/delservice', 'InvoicesController@delservice');
	Route::post('dashboard/work/invoices/insert', 'InvoicesController@insert');
	Route::post('dashboard/work/invoices/attachment', 'InvoicesController@attachment');
	Route::post('dashboard/work/invoices/upload', 'InvoicesController@upload');
	Route::post('dashboard/work/invoices/attachmentupdate','InvoicesController@attachmentupdate')->name('invoices.attachment.update');
});

Route::middleware(['auth', 'permission.admin'])->group(function() {
	Route::post('dashboard/work/jobs/add-team', 'JobsController@addTeam');

	Route::get('dashboard/management/team', 'ManageController@team');
	Route::get('dashboard/management/team/new', 'ManageController@newTeam');
	Route::post('dashboard/management/team/addTeam', 'ManageController@addTeam');
	Route::get('dashboard/management/team/edit/{id}', 'ManageController@editTeam');
	Route::post('dashboard/management/team/updateTeam', 'ManageController@updateTeam');
	Route::get('dashboard/management/team/deleteTeam/{id}', 'ManageController@deleteTeam');
	Route::post('dashboard/management/team/uploadPhoto', 'ManageController@uploadPhoto');
	
	Route::get('dashboard/management/report', 'ReportController@index');
	Route::get('dashboard/management/payroll', 'ManageController@payroll');
	Route::get('dashboard/management/payroll/{member_id}/expenses', 'ManageController@expenses');
	Route::get('dashboard/management/approve', 'ManageController@approve');
	Route::get('dashboard/management/approve/approved/{date}', 'ManageController@approved');
	Route::get('dashboard/management/approve/markpaid/{date}', 'ManageController@markpaid');

	Route::get('dashboard/management/report', 'ReportController@index');

	Route::get('dashboard/management/services', 'ManageController@service')->name('services.index');
	Route::match(['GET', 'POST'], 'dashboard/management/services/new', 'ManageController@add_service')->name('service.add');
	Route::match(['GET', 'POST'], 'dashboard/management/services/{id}/edit', 'ManageController@edit_service')->name('service.edit');
	Route::match(['GET', 'POST'], 'dashboard/management/products/new', 'ManageController@add_product')->name('product.add');
	Route::match(['GET', 'POST'], 'dashboard/management/products/{id}/edit', 'ManageController@edit_product')->name('product.edit');
	Route::post('dashboard/management/services/sort_all', 'ManageController@sort_all')->name('services.sortall');
	Route::post('dashboard/management/services/delete/{id}', 'ManageController@delete')->name('services.delete');


	Route::post('dashboard/jobs/getteampositions', 'JobsController@getteampositions');


	Route::get('dashboard/management/taxes', 'ManageController@taxes')->name('tax.index');
	Route::match(['GET', 'POST'], 'dashboard/management/taxes/new', 'ManageController@add_tax')->name('tax.add');
	Route::match(['GET', 'POST'], 'dashboard/management/taxes/{id}/edit', 'ManageController@edit_tax')->name('tax.edit');
});


/********************** api *******************************/
Route::post('api/v1/login', 'Api\ApiUserController@login');
Route::post('api/v1/signup', 'Api\ApiUserController@signup');

Route::middleware(['auth.api'])->group(function() {
	// user
	Route::post('api/v1/user/change_password', 'Api\ApiUserController@change_password');
	Route::post('api/v1/user/location/update', 'Api\ApiUserController@update_location');
	Route::post('api/v1/logout', 'Api\ApiUserController@logout');

	// schedule
	Route::get('api/v1/schedule/{date}/getall/{team_id}', 'Api\ApiScheduleController@get_schedules');

	// event
	Route::get('api/v1/event/{date}/info', 'Api\ApiScheduleController@get_event');

	// timesheet
	Route::get('api/v1/timesheet/getall/{date}', 'Api\ApiTimesheetController@get_timesheets');
	Route::post('api/v1/timesheet/save', 'Api\ApiTimesheetController@save');
	Route::post('api/v1/timesheet/start', 'Api\ApiTimesheetController@start');
	Route::post('api/v1/timesheet/stop', 'Api\ApiTimesheetController@stop');

	Route::get('api/v1/service/getall', 'Api\ApiQuoteController@get_services');
	Route::get('api/v1/tax/getall', 'Api\ApiClientController@get_taxes');

	// client
	Route::post('api/v1/client/add', 'Api\ApiClientController@add');
	Route::post('api/v1/client/update', 'Api\ApiClientController@update');
	Route::get('api/v1/client/getall', 'Api\ApiClientController@get_clients');
	Route::get('api/v1/client/{id}/property/getall', 'Api\ApiClientController@get_clients_properties');
	Route::get('api/v1/client/{id}/info', 'Api\ApiClientController@info');
	Route::get('api/v1/client/{date}/getall', 'Api\ApiClientController@get_clients_by_date');

	// Invoice
	Route::post('api/v1/invoice/add', 'Api\ApiInvoiceController@add');
	Route::post('api/v1/invoice/update', 'Api\ApiInvoiceController@update');
	Route::post('api/v1/invoice/send_email', 'Api\ApiInvoiceController@send_email');

	// Quote
	Route::post('api/v1/quote/add', 'Api\ApiQuoteController@add');
	Route::post('api/v1/quote/update', 'Api\ApiQuoteController@update');
	Route::post('api/v1/quote/approve', 'Api\ApiQuoteController@approve');
	Route::post('api/v1/quote/send_email', 'Api\ApiQuoteController@send_email');
	Route::get('api/v1/quote/{quote_id}/info', 'Api\ApiQuoteController@get_quote');

	// Property
	Route::post('api/v1/property/save', 'Api\ApiPropertyController@save');	

	// Task
	Route::get('api/v1/task/{task_id}/info', 'Api\ApiTaskController@get_task');
	Route::post('api/v1/task/add', 'Api\ApiTaskController@add');
	Route::post('api/v1/task/update', 'Api\ApiTaskController@update');
	Route::post('api/v1/task/complete', 'Api\ApiTaskController@complete');

	// Team
	Route::get('api/v1/team/getall', 'Api\ApiTeamController@get_teams');

	// job
	Route::get('api/v1/job/descriptions', 'Api\ApiJobController@get_descriptions');
	Route::get('api/v1/job/getall', 'Api\ApiJobController@get_jobs');
	Route::get('api/v1/job/{job_id}/info', 'Api\ApiJobController@get_job_info');
	Route::post('api/v1/job/add', 'Api\ApiJobController@add');
	Route::post('api/v1/job/update', 'Api\ApiJobController@update');

	// visit
	Route::get('api/v1/visit/{visit_id}/info', 'Api\ApiJobController@get_visit');
	Route::post('api/v1/visit/add', 'Api\ApiJobController@add_visit');
	Route::post('api/v1/visit/update', 'Api\ApiJobController@update_visit');
	Route::post('api/v1/visit/complete', 'Api\ApiJobController@complete');
});

// client hub
Route::match(['GET', 'POST'], 'clienthub/login', 'ClienthubController@login')->name('client_login');
Route::match(['GET', 'POST'], 'clienthub/signup', 'ClienthubController@signup')->name('client_signup');
Route::middleware(['auth.client'])->group(function() {
	Route::get('clienthub', 'ClienthubController@index');
	Route::get('clienthub/logout', 'ClienthubController@logout');
	Route::get('clienthub/{user_id}/quotes/{quote_id}', 'ClienthubController@quotes');
	Route::get('clienthub/{user_id}/invoices/{invoice_id}', 'ClienthubController@invoices');
	Route::get('clienthub/generate-pdf/{user_id}/{quote_id}', 'ClienthubController@pdfview');
	Route::get('clienthub/generate-pdf/{user_id}/{invoice_id}', 'ClienthubController@pdfview');
	Route::post('clienthub/{user_id}/quotes/{quote_id}/update', 'ClienthubController@updatequotestatus');
});