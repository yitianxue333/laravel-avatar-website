@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">

<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo"><span class="capitalize">{{$member->fullname}}</span>'s Expenses</h2>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-6 jobTypePanel" id="">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h3 class="headingTwo">Logged hours</h3>
                            </div>
                        @if(!empty($data_approved))
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="paragraph headingTwo u-marginBottomSmall">Paid to</p>
                                        <div class="approve-date date filters" id="approveDate">
                                                <input type="text" class="action-border input-lg form-control input-group-addon" id="amount" value =""/>
                                        </div>
                                        <div id="slider-range">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 userApprove loggedHours">
                                        <div class="div-table" id="approveDropdown">
                                        @foreach($data_approved as $key=>$one)
                                            <div class="table-row table-row-color" data-date="{{$one->save_date}}" data-hour="{{$one->total_hour}}">
                                                <a class="table-rowLink u-colorGreyBlue" href="#">
                                                    <div class="col-sm-3">
                                                        <span class="paragraph headingTwo">{{$one->date}}</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <span class="paragraph">{{$one->day}}</span>
                                                    </div>            
                                                    <div class="col-sm-3">
                                                        <span class="paragraph">{{$one->total_hour}}</span>
                                                    </div>
                                                    <div class="col-sm-2 text-right">
                                                    @if($one->save_date < $today)
                                                        <i class="jobber-icon jobber-2x jobber-checkmark"></i>
                                                    @else
                                                        <i class="jobber-icon jobber-2x jobber-alert"></i>
                                                    @endif
                                                    </div>
                                                </a>      
                                            </div>
                                           @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="ibox-content min-flex">
                            <div class="row">
                                <div class="col-md-2">
                                    <i class="jobber-icon jobber-2x jobber-time icon-circle icon-bg icon--gray"></i>
                                </div>
                                <div class="col-md-10">
                                    <p class="paragraph u-textBold"><span class="capitalize">{{$member->fullname}}</span>'s hours are fully paid</p>
                                    <p class="paragraph">Any logged hours that are unpaid will appear here</p>
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                        </div>
                     
                </div>
               <!--  <div class="col-md-6 jobTypePanel">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Reimbursable job expenses</p></h3>
                        </div>
                        @if(!empty($data_approved))
                            <div class="ibox-content" style="min-height: 200px;">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="jobber-icon jobber-2x jobber-expense icon-circle icon-bg icon--gray"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="paragraph u-textBold"><span class="capitalize">{{$member->fullname}}</span> has no outstanding expenses</p>
                                        <p class="paragraph">Any logged expenses will appear here</p>
                                        
                                    </div>
                                </div>
                            </div>
                        @else
                             <div class="ibox-content" style=";">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="jobber-icon jobber-2x jobber-expense icon-circle icon-bg icon--gray"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="paragraph u-textBold">Expenses are not turned on</p>
                                        <p class="paragraph">Avoid forgotten expenses and lost receipts</p>
                                        <a class="button button--green button--ghost button--small" 
                                                href="#">
                                            Turn On Expenses
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div> -->
                <div class="col-md-6 jobTypePanel">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Payroll summary</p></h3>
                        </div>
                        @if (!empty($data_approved))
                        <div class="ibox-content">
                            <p class="paragraph u-textNormal">Total Hours: <span class="totalHour">{{$data_min_max->total_d}}</span></p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="approveNotice">
                                        <span class="paragraph u-textNormal">
                                            Unapproved hours have been included and will be automatically approved if marked paid
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <span></span>
                        @endif
                    </div>
                    <div class="col-md-12 text-right">
                        <a class="cancelAdd-btn button--greyBlue button--ghost" tabindex="-1" href="/dashboard/management/payroll">Cancel</a>
                        <a name="button" type="" class="btn-job form-submit" remote="true" data-onclick-submit="" onClick="send(this)">Mark Paid</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<input class="hidden-data" name="min_day" value="{{$data_min_max->min_day}}"></input>
<input class="hidden-data" name="max_day" value="{{$data_min_max->max_day}}"></input>
<input class="hidden-data" name="total_hours" value="{{$data_min_max->total_d}}"></input>
<input class="hidden-data" name="today" value="{{$today}}"></input>
<input class="hidden-data" id="id" value="{{$member->team_member_id}}"></input>

<script type="text/javascript">
    var max_date = $('input[name=max_day]').val();
    var min_date = $('input[name=min_day]').val();
    $(document).ready(function(){
        $('#slider-range a').first().addClass('hidden-data');
        $('#amount').val(max_date);
    });

    function send(ele) {
        var date = $('#amount').val();
        var id = $('#id').val();
        $(ele).attr('href', '/dashboard/management/approve/markpaid/'+date+'_'+id);
    }
    String.prototype.replaceAll = function(target, replacement) {
      return this.split(target).join(replacement);
    };
    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        return hours+':'+minutes+':'+seconds;
    }

     var $datepicker =$('#approveDate').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
               
            }
        });
    var $slider = $("#slider-range").slider({
          range: true,
          min: new Date(min_date).getTime() / 1000,
          max: new Date(max_date).getTime() / 1000,
          step: 86400,
          values: [ new Date(min_date).getTime() / 1000, new Date(max_date).getTime() / 1000 ],
          slide: function( event, ui ) {
            date = new Date(ui.values[ 1 ] *1000);
            year = date.getFullYear();
            month = date.getMonth()+1;
            dt = date.getDate()+1;

            if (dt < 10) {
              dt = '0' + dt;
            }
            if (month < 10) {
              month = '0' + month;
            }
            $datepicker.datepicker('setDate', year + '-' + month + '-' + dt);
          }

    });
    $(document).on('change', 'div.filters input', function (ele) {
        var max = $('div.filters input').val();
        var container = document.getElementById("approveDropdown");
        var selectBox = 'data-date';
        var selecthbox = 'data-hour';

        var sortItems = document.querySelectorAll('['+ selectBox +']'); 
        var sorthItems = document.querySelectorAll('['+ selecthbox +']'); 

        for(var i=0; i<sortItems.length; i++){
            if(sortItems[i].getAttribute(selectBox) <= max) {
                var total_sec = 0;
                var date = sortItems[i].getAttribute(selectBox);
                $('div['+selectBox+'='+date+']').css('background-color','#fbf7dc');
                for(var j = 0; j<=i;j++){
                    var time = sorthItems[j].getAttribute(selecthbox);
                    var a = time.split(':'); // split it at the colons
                    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

                    var total_sec = total_sec + seconds;
                }

                // $('.u-textNormal span').text(total_sec.toString().toHHMMSS());
                // if($('input[name=total_hours]').val() === total_sec.toString().toHHMMSS()) {
                //     $('.approveNotice').css('display', 'block');
                // }
                // else{
                //     $('.approveNotice').css('display', 'none');

                // }
                
                $('.u-textNormal span').text(total_sec.toString().toHHMMSS());
                if(date >= $('input[name = today]').val()) {
                    $('.approveNotice').css('display', 'block');
                }
                else{
                    $('.approveNotice').css('display', 'none');

                }

            }
            else{
                var date = sortItems[i].getAttribute(selectBox);
                $('div['+selectBox+'='+date+']').css('background-color','#fff');
            }      
        }
    });
        
</script>
<script type="text/x-jquery-tmpl" id="lineItemRow">
    
</script>
@stop