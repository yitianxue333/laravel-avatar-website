@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<style type="text/css" id="counter"></style>
<div class="wrapper wrapper-content">
        
        <div class="row">
            
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Today's hours</h5>
                    </div>
                    <div class="ibox-content hour">
                        <canvas id="mycanvas" width="250" height="250"></canvas>
                        <canvas id="showclock" width="250" height="100"></canvas>
                        <div class='second'>
                            <div class='hand'></div>
                        </div>
                    </div>
                   
                    <div class="ibox-content hour processing-hour">
                        <table class="box-table">
                            <tr>
                                <td>Working hours <br> <strong>{{$data->hour}}</strong></td>
                                <td>Ammount Total <br> <strong>$ {{$data->total}}</strong></td>
                            </tr>
                             <tr>
                                <td>Overdue <br> <strong>$ {{$data->overdue}}</strong></td>
                                <td>% Overall work <br> <strong>{{$data->overwork}} %</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="ibox-content hour ">
                        <div class="rest-hour counter">
                            <label class="counter" onClick="starttimer();">Start Timer</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 dashboard">
                    <div class="border-board box_title">
                        <span class="card-headerTitle ">Assignments</span>
                    </div>
                    <div class="b-content border-board">
                        <div class="col-md-12">
                            <div class="row overflow" style="border: 1px solid #e0e0e0; background-color: #fff;">
                                <!-- <div class="col-md-12"> -->
                                @foreach($assign as $key => $one)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$one->job_id}}/view" data-type="">
                                    <div class="row board-assign">
                                        <div class="large-expand columns col-sm-4">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$one->job_id}} &nbsp </span><span class="first_name_text">
                                            <?php 
                                                if(!empty($one->title)){
                                                    $title = explode('-', $one->title);
                                                    echo $title[0].' - <br><small>'.$title[1].'</small>';
                                                   
                                                }
                                                else{
                                                    echo $one->title;
                                                }
                                            ?>
                                            </span></h3>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <small>{{$one->street1}} 
                                            {{$one->street2}} {{$one->city}} {{$one->state}}
                                            {{$one->zip_code}}</small>
                                        </div>
                                        <div class="columns col-sm-2">
                                            <small><strong>From:</strong> {{$one->start_time}} 
                                            <br><strong>To:</strong> {{$one->end_time}}</small>
                                        </div>
                                        <div class="columns col-sm-3">
                                            <small>Assign to <br>{{$one->name}}</small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                @foreach($not_assigns as $key => $one)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$one->job_id}}/view" data-type="">
                                    <div class="row board-assign">
                                        <div class="large-expand columns col-sm-4">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$one->job_id}} &nbsp </span>
                                            <span class="first_name_text">
                                            <?php 
                                                if(!empty($one->title)){
                                                    $title = explode('-', $one->title);
                                                    echo $title[0].' - <br><small>'.$title[1].'</small>';
                                                   
                                                }
                                                else{
                                                    echo $one->title;
                                                }
                                            ?>
                                            
                                            <!-- <small>{{$one->title}}</small> -->

                                            </span>
                                            </h3>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <small>{{$one->street1}} 
                                            {{$one->street2}}  {{$one->city}} {{$one->state}}  
                                            {{$one->zip_code}} </small>
                                        </div>
                                        <div class="columns col-sm-2">
                                            <small><strong>From:</strong> {{$one->start_time}} 
                                            <br><strong>To:</strong> {{$one->end_time}}</small>
                                        </div>
                                        <div class="columns col-sm-3">
                                            <small>not assign yet</small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>   
            </div>
            
        </div>

        <div class="row">
                <div class="col-md-4 collapse-balance board" >
                    <div class="ibox float-e-margins">
                         <div class="ibox-content balance info">
                                <div class="feed-activity-list">
                                    <div class="feed-element row">
                                        <div  class="pull-left col-sm-3">
                                           <span class="badge circle badge-balance">
                                                <i class="jobber-icon jobber-3x jobber-invoice"></i>
                                            </span>
                                        </div>
                                        <div  class="pull-left col-sm-8">
                                            <div class="media-body ">
                                                <span class="font-bold pull-right"><h4>Balance</h4></span><br><br>
                                                <h2 class="font-bold no-margins">
                                                    @if(!empty($totalprice))
                                                    $ {{number_format($totalprice, 2, '.', ',')}} Balances
                                                    @else
                                                        No outstanding balances
                                                    @endif
                                                </h2>
                                                <br>
                                                <div class="div-divider"></div>
                                                <br> 
                                                <div>
                                                    <a class="balance-link white-href pull-right">View more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                        </div>
                    </div>
                </div>

               <!--  <div class="col-lg-4 collapse-balance board">
                    <div class="widget-head-color-box navy-bg p-lg text-center balance">
                        <div class="m-b-md">
                            <h3 class="font-bold no-margins">
                                @if(!empty($totalprice))
                                $ {{number_format($totalprice, 2, '.', ',')}} Balances
                                @else
                                    No outstanding balances
                                @endif
                            </h3>
                            <br>
                            <span class="font-bold"><h4>Balance</h4></span>
                        </div>
                        <span class="badge circle badge-balance">
                            <i class="jobber-icon jobber-2x jobber-alert"></i>
                        </span>
                        </button>
                        <div>
                            <span class="font-bold"><h3>outstanding balance</h3></span>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-4 expand-balance">
                    <div class="border-board box_title">
                        <span class="card-headerTitle ">Outstanding balances</span>
                    </div>
                    <div class="b-content border-board">
                        <div class="box-content">
                            <div class="">
                                <label class="color-board">{{count($invoice)}} clients owe you</label><br>
                                <span class="price-label">$ {{number_format($totalprice, 2, '.', ',')}}</span><br><br>
                            </div>
                            <div class ="inbox-title-header "> 
                                <label class="color-board l-uppercase">client</label>
                                <label class="right color-board l-uppercase">amount</label>
                            </div>
                            <span class="div-divider space-divider"></span>
                            @foreach($invoice as $key =>$one)
                            <a class="inbox-title-header row" href="/dashboard/work/invoices/info/{{$one->invoice_id}}">
                                <div class="p-l-r" >
                                <label class="b-individual-font b-margin">{{$one->first_name}} &nbsp {{$one->last_name}}</label>
                                <label class="b-individual-font right">{{$one->price}}<br><span class="date-past">{{$one->diff}} days ago</span></label>
                                </div>
                            </a>
                            @endforeach
                            <a class="button button--fill button--greyBlue button--ghost button--small u-marginTopSmall report" href="#">
                                        View Report
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 collapse-invoice board" >
                    <div class="ibox float-e-margins">
                         <div class="ibox-content invoice info">
                                <div class="feed-activity-list">
                                    <div class="feed-element row">
                                        <div  class="pull-left col-sm-3">
                                           <span class="badge circle badge-invoice">
                                                <i class="jobber-icon jobber-3x jobber-alert"></i>
                                            </span>
                                        </div>
                                        <div  class="pull-left col-sm-8">
                                            <div class="media-body ">
                                                <span class="font-bold pull-right"><h4>Past invoices</h4></span><br><br>
                                                <h2 class="font-bold no-margins">
                                                    @if(count($invoice) !=0 )
                                                        {{count($invoice)}} past due invoices
                                                    @else
                                                        No past due invoices
                                                    @endif
                                                </h2>
                                                <br>
                                                <div class="div-divider"></div>
                                                <br> 
                                                <div>
                                                    <a class="invocies-link white-href pull-right">View more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="col-lg-4 collapse-invoice board">
                    <div class="widget-head-color-box navy-bg p-lg text-center invoice">
                        <div class="m-b-md">
                            <h3 class="font-bold no-margins">
                                @if(count($invoice) !=0 )
                                    {{count($invoice)}} past due invoices
                                @else
                                    No past due invoices
                                @endif
                            </h3>
                            <br>
                            <span class="font-bold"><h4>Past invoices</h4></span>
                        </div>
                        <span class="badge circle  badge-invoice">
                            <i class="jobber-icon jobber-2x jobber-invoice"></i>
                        </span>
                        </button>
                        <div>
                            <span class="font-bold"><h3>Past due invoices</h3></span>
                        </div>
                    </div>
                </div> -->
               <div class="col-md-4 expand-invoice">
                    <div class="border-board box_title">
                        <span class="card-headerTitle ">Past due invoices</span>
                    </div>
                    <div class="b-content border-board">
                        <div class="box-content">
                            @foreach($invoice_u as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape invoice-u"> < 30</label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach
                            @foreach($invoice_e as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape invoice-e">30 - 60</label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach
                            @foreach($invoice_o as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape invoice-o">  > 60</label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach

                            <div class = "div-divider m-space"></div>
                            <div class ="inbox-title-header "> 
                                <label class="color-board l-uppercase">client</label>
                                <label class="right color-board l-uppercase">amount</label>
                            </div>
                            <span class="div-divider space-divider"></span>
                            @foreach($invoice as $key =>$one)
                            <a class="inbox-title-header row" href="/dashboard/work/invoices/info/{{$one->invoice_id}}">
                                 <div class="p-l-r">
                                <label class="b-individual-font b-margin">{{$one->first_name}} &nbsp {{$one->last_name}}</label>
                                <label class="b-individual-font right">{{$one->price}}<br><span class="date-past">{{$one->diff}} days ago</span></label>
                                </div>
                            </a>
                            @endforeach
                            <a class="button button--fill button--greyBlue button--ghost button--small u-marginTopSmall report" href="/dashboard/work/invoices">
                                        View All Invoices
                            </a>

                        </div>
                    </div>
                </div>

               <div class="col-md-4 collapse-upcoming board" >
                    <div class="ibox float-e-margins">
                         <div class="ibox-content upcoming info">
                                <div class="feed-activity-list">
                                    <div class="feed-element row">
                                        <div  class="pull-left col-sm-3">
                                           <span class="badge circle badge-upcoming">
                                                <i class="jobber-icon jobber-3x jobber-job"></i>
                                            </span>
                                        </div>
                                        <div  class="pull-left col-sm-8">
                                            <div class="media-body ">
                                                <span class="font-bold pull-right"><h4>upcoming jobs</h4></span><br><br>
                                                <h2 class="font-bold no-margins">
                                                     @if(count($upcomings) != 0)
                                                            {{count($upcomings)}} upcoming jobs
                                                        @else
                                                            ​No upcoming jobs
                                                        @endif
                                                </h2>
                                                <br>
                                                <div class="div-divider"></div>
                                                <br> 
                                                <div>
                                                    <a class="upcoming-link white-href pull-right">View more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="col-lg-4 collapse-upcoming board">
                    <div class="widget-head-color-box navy-bg p-lg text-center upcoming">
                        <div class="m-b-md">
                            <h3 class="font-bold no-margins">
                                @if(count($upcomings) != 0)
                                    {{count($upcomings)}} upcoming jobs
                                @else
                                    ​No upcoming jobs
                                @endif
                            </h3>
                            <br>
                            <span class="font-bold"><h4>upcoming jobs</h4></span>
                        </div>
                        <span class="badge circle badge-upcoming">
                            <i class="jobber-icon jobber-2x jobber-job"></i>
                        </span>
                        </button>
                        <div>
                            <span class="font-bold"><h3>upcoming jobs</h3></span>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-4 expand-upcoming">
                    <div class="border-board box_title">
                        <span class="card-headerTitle ">Upcoming jobs</span>
                    </div>
                    <div class="b-content border-board">
                        <div class="box-content">
                            @foreach($upcoming7 as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape">Next 7 Days</label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach
                            @foreach($upcoming15 as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape">7 Days - 15 Days</label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach
                            @foreach($upcoming30 as $key =>$one)
                            @if($one->cnt != '')
                            <div class="period">
                                <label class="button-shape"> 15 Days - </label>
                                <label class="right">{{$one->cnt}} jobs -<span class="font-price"> $  {{number_format($one->total, 2, '.', ',')}}</span></label>
                            </div>
                            @endif
                            @endforeach
                            <div class = "div-divider m-space"></div>
                            <div class ="inbox-title-header "> 
                                <label class="color-board l-uppercase">client</label>
                                <label class="right color-board l-uppercase">when</label>
                            </div>
                            <span class="div-divider space-divider"></span>
                            @foreach($upcomings as $key =>$one)
                            <a class="inbox-title-header row" href="/dashboard/work/jobs/{{$one->job_id}}/view">
                                <div class="p-l-r">
                                    <label class="b-individual-font">{{$one->first_name}} {{$one->last_name}}</label>
                                    @if($one->date_ended >= $today && $one->date_started<= $today)
                                    <label class="b-individual-font right">Today</label>
                                    @elseif($one->date_started > $today)
                                    <label class="b-individual-font right">{{$one->a_mon}}</label>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                            <a class="button button--fill button--greyBlue button--ghost button--small u-marginTopSmall report" href="/dashboard/work/jobs">
                                        View All Jobs
                            </a>

                        </div>
                    </div>
                </div>
        </div>

<script type="text/javascript">
      $('.balance-link').click(function(){
        $('.collapse-balance').hide();
        $('.expand-balance').show();
      });

      $('.invocies-link').click(function(){
        $('.collapse-invoice').hide();
        $('.expand-invoice').show();
      });

      $('.upcoming-link').click(function(){
        $('.collapse-upcoming').hide();
        $('.expand-upcoming').show();
      });
</script>
<script type="text/javascript" src="{{url('public/js/clock.js')}}"></script>
<script >
    drawCanvas();

    function starttimer(){
       drawScreen();
        // canvasScreen(drawScreen,1000);
    }
</script>

@stop
