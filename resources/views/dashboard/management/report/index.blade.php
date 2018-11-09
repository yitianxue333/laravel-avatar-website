@extends('layout.menu')
@section('content')
<dir>
   <div class="gray-bg management-report">
      <div class="wrapper wrapper-content animated fadeInRight">
         <div class="row">
            <div class="col-lg-3 report-table">
               <div class="ibox float-e-margins">
                  <div class="ibox-content">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><h4>Financial reports</h4></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Projected income</h4>
                                 <p>Projected income from invoices awaiting payment</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Transaction list</h4>
                                 <p>All transaction from invoices, payments & deposites</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>invoices</h4>
                                 <p>All invoices that are drafts, outstanding, paid or bad debt</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Taxation</h4>
                                 <p>Tax totals, total awaiting collection, and total by tax rate</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Aged receivables</h4>
                                 <p>Invoices that are late by 30, 60 and 90+ days</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Bad debt</h4>
                                 <p>All invoices marked as bad debt</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Client balance summary</h4>
                                 <p>Full list of customer account balances</p>
                                 </a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 report-table">
               <div class="ibox float-e-margins">
                  <div class="ibox-content">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><h4>Work reports</h4></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Visits</h4>
                                 <p>Detailed list of past and upcoming visits</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>One-off jobs</h4>
                                 <p>Detailed list of all recurring jobs</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Recurring jobs</h4>
                                 <p>Detailed list of all recurring jobs</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Quotes created</h4>
                                 <p>Detailed list of all created quotes</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Quotes converted</h4>
                                 <p>Detailed list of quotes that have been converted into jobs</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>product and services</h4>
                                 <p>Full usage of products and services on quotes, jobs, and invoices</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Waypoints</h4>
                                 <p>Full list of GPS waypoints logged</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Timesheets</h4>
                                 <p>All time tracked for the team</p>
                                 </a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 report-table">
               <div class="ibox float-e-margins">
                  <div class="ibox-content">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><h4>Client reports</h4></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Client communications</h4>
                                 <p>All eamil messages sent through Jobber</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Client contact info</h4>
                                 <p>All clients and their contact info</p>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Property list</h4>
                                 <p>All properties and details</p>
                                 </a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 report-table">
               <div class="ibox float-e-margins">
                  <div class="ibox-content">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><h4>Expense report</h4></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                              <a href="/dashboard/management/report">
                                 <h4>Expenses</h4>
                                 <p>All tracked expenses and their details</p>
                                 </a>
                                 
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <link rel="stylesheet" type="text/css" href="{{ url('/css/custom-pcs.css') }}">
</dir>
@stop