@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo">Confirm Payroll</h2>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <p class="paragraph">Keep tabs on your payroll by updating the status of submitted timesheets and reimbursable expenses.</p>
                </div>
                <div class="col-md-12 jobTypePanel" id="">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Team</h3>
                        </div>
                        <div class="ibox-content no-padding">
                            <div class="div-table">
                                <div class="table-row table-row--columnHeader">
                                  <div class="col-md-4">
                                    Name
                                  </div>
                                  <div class="col-md-2">
                                    Expenses
                                  </div>
                                  <div class="col-md-2">
                                    Hours
                                  </div>
                                  <div class="col-md-4">
                                    Status
                                  </div>
                                </div>
                                @if($data_members !='')
                                @foreach($data_members as $key =>$one)
                                <div class="table-row">
                                    <a class="table-rowLink u-colorGreyBlue" href="/dashboard/management/payroll/{{$one['member_id']}}/expenses">
                                        <div class="col-sm-4">
                                            <div class="avatar u-inlineBlock">
                                                <span class="avatar-initials">{{substr($one['fullname'],0,1)}}</span>
                                            </div>
                                            {{$one['fullname']}}
                                        </div>
                                        @foreach($one['expenses'] as $key=>$expense)
                                        @if(empty($expense->total_expense))
                                        <div class="col-sm-2">
                                          <div class="table-data u-marginTopSmallest" data-label="Expenses">
                                            $0.00
                                          </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="table-data u-marginTopSmallest" data-label="Hours">
                                              0:00
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-sm-2">
                                          <div class="table-data u-marginTopSmallest" data-label="Expenses">
                                            ${{$expense->total_expense}}
                                          </div>
                                        </div>
                                        <div class="col-sm-2">
                                              <div class="table-data u-marginTopSmallest" data-label="Hours">
                                            {{$expense->total_hour}}
                                              </div>
                                        </div>            
                                        @endif                                     
                                        <div class="col-sm-4">
                                          <div class="table-data u-marginTopSmallest" data-label="Status">
                                              @if(!empty($expense->total_expense))
                                                <span class="jobber-icon jobber-2x jobber-alert icon-flex awaiting-color"></span>
                                                <span class="in-icon-font awaiting-color">Awaiting &nbsp  payment
                                                  </span>
                                              @else
                                                <span class="jobber-icon jobber-2x jobber-checkmark icon-flex"><span class="in-icon-font">paid</span></span>
                                              @endif
                                          </div>
                                        </div>
                                        @endforeach
                                    </a>      
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ url('public/js/country.js')}}"></script>
<script type="text/javascript">
   
   
</script>


@stop