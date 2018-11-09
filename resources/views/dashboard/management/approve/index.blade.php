@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo">Approve Timesheets</h2>
        </div>
        @if(isset($success))
            <div class="flash flash--success clearfix hideForPrint js-flash">
                <div class="flash-content">{{$success}} </div>
                <i class="pull-right jobber-icon jobber-2x jobber-cross" class="js-dismissFlash icon" onClick = "hideflash(this);"></i>
            </div>
        @endif

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-8 jobTypePanel" id="">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Logged hours awaiting approval</h3>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="paragraph headingTwo u-marginBottomSmall">Approve to</p>
                                    <div class="approve-date date filters" id="approveDate">
                                            <input type="text" class="action-border input-lg form-control input-group-addon" id="amount" value=""/>
                                    </div>
                                    <div id="slider-range">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @foreach($data_day as $member)
                    @if(!empty($member['data']))
                    <div class="ibox userApprove">
                        <div class="ibox-content fill-padding">
                       
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 25px;">
                                    <label class="check-element">
                                        <input type="checkbox" class="check-button" name="approveMenu" value="1" checked="" >
                                        <i class="checkbox fa"></i>
                                    </label>
                                    <div class="avatar u-inlineBlock">
                                        <span class="avatar-initials">{{substr($member['fullname'],0,1)}}</span>
                                    </div>
                                    <span class="paragraph">{{$member['fullname']}}</span>
                                    <label class = "pull-right right-label">
                                            {{$member['total']}}
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <ul class="div-table" id="approveDropdown">
                                    @foreach($member['data'] as $key =>$one)
                                        <li class="table-row table-row-color" name ="date" data-date="{{$one->save_date}}" data-hour="{{$one->s_duration}}">
                                            <!-- <input class="hidden-data"></input> -->
                                            <div class="table-rowLink u-colorGreyBlue" href="#">
                                                <div class="col-sm-4">
                                                    <span class="paragraph headingTwo">{{$one->a_mon}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="paragraph">{{$one->a_day}}</span>
                                                </div>            
                                                <div class="col-sm-4 text-right">
                                                    <span class="paragraph">{{$one->s_duration}}</span>
                                                </div>
                                            </div>      
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                     @endforeach
                    <div></div>
                    <a  class="btn-job addItem-btn" style="float: right;" onClick = "send(this)">Approve</a>
                </div>
                <div class="col-md-4 approveAwating">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h3 class="headingTwo">No logged hours awaiting approval for:</h3>
                        </div>
                        <div class="ibox-content">
                            @if(count($members) != 0) 
                                {{$members[0]->fullname}},
                            @endif
                            @for($i = 1; $i < count($members) ; $i++)
                                {{$members[$i]->fullname}},
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-md-8"></div>
            </div>
        </div>
    </div>
<input class="hidden-data" name="min_day" value="{{$data_min_max->min_day}}"></input>
<input class="hidden-data" name="max_day" value="{{$data_min_max->max_day}}"></input>


<script type="text/javascript">
    function send(ele) {
        var date = $('#amount').val();
        console.log(date);
        $(ele).attr('href', '/dashboard/management/approve/approved/'+date);
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
    var max_date = $('input[name=max_day]').val();
    var min_date = $('input[name=min_day]').val();

    $(document).ready(function(){
        $('#amount').val(max_date);
        $('#slider-range a').first().addClass('hidden-data');
        $('input[name=approveMenu]').change(function(){
            if ($(this).prop('checked') == true) {
                $(this).parent().parent().parent().children('.col-md-12').find('#approveDropdown').show();
            }else{
                 $(this).parent().parent().parent().children('.col-md-12').find('#approveDropdown').hide();
            }
        })
    });
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

            // $( "#amount" ).val( year + '-' + month + '-' + dt );
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
                $('li['+selectBox+'='+date+']').css('background-color','#fbf7dc');
                for(var j = 0; j<=i;j++){
                    var time = sorthItems[j].getAttribute(selecthbox);
                    var a = time.split(':'); // split it at the colons
                    // console.log(time);
                    // minutes are worth 60 seconds. Hours are worth 60 minutes.
                    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

                    var total_sec = total_sec + seconds;
                }
                // $('.pull-right.right-label').text(total_sec.toString().toHHMMSS());
            }
            else{
                var date = sortItems[i].getAttribute(selectBox);
                $('li['+selectBox+'='+date+']').css('background-color','#fff');
            }      
        }
    });
     function hideflash(ele){
        $(ele).parent().hide();
    }
</script>

<script type="text/x-jquery-tmpl" id="lineItemRow">
    
</script>
@stop