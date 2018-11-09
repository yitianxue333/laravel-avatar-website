@extends('layout.menu')

@section('content')
        
<!-- <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
    @endif
</div> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="">
                        <div class="col-md-12">
                            @if(isset($data['success'])) 
                              <br>
                              <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                {{$data['success']}}
                              </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <div class="list-title">
                                        <span class="">
                                            User and permissons
                                        </span>
                                        <a href="/dashboard/management/team/new" class="assign-btn assign-btn-sm right-btn u-block text-center" >Add User</a>
                                    </div>

                                    <div class="user-list">

                                        <table class="table table-hover" id="user_list">
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td class="user-select">
                                                        <label class="check-element">
                                                            <input type="checkbox" class="check-button" name="" value="1">
                                                            <i class="checkbox fa"></i>
                                                            <!-- <span>
                                                                <i class="fa fa-star"></i>
                                                            </span> -->
                                                        </label>
                                                    </td>
                                                    <td class="user-field">
                                                        <span class="profile">
                                                            @if($user->photo)
                                                                <img src="{{url('public/profile')}}/{{$user->photo}}" width="40" height="40">
                                                            @else
                                                                <?php
                                                                    $name_array = explode(' ', $user->fullname);
                                                                    for($i = 0; $i < count($name_array); $i ++) {
                                                                        if(strlen($name_array[$i]) > 0)
	                                               			    echo $name_array[$i][0];
                                                                    }
                                                                ?>
                                                            @endif
                                                        </span>
                                                        <div>
                                                            <a href="#" class="user-name">{{$user->fullname}}</a>
                                                            <br/>
                                                            <small class="user-roll">
                                                            @if($user->permission == 1)
                                                                ACOUNT OWNER
                                                            @elseif($user->permission == 2)
                                                                ADMIN
                                                            @elseif($user->permission == 3)
                                                                Limited Worker
                                                            @elseif($user->permission == 4)
                                                                Woker
                                                            @elseif($user->permission == 5)
                                                                Dispatcher
                                                            @else
                                                                Manager
                                                            @endif
                                                            </small>

                                                            
                                                        </div>
                                                    </td>
                                                    <td class="user-id">
                                                        <span class="">{{$user->email}}</span>
                                                    </td>
                                                    <td class="login-date">
                                                        <span class="">Last login: Today</span>
                                                    </td>
                                                    <td class="project-actions">
                                                        <a href="{{url('/dashboard/management/team/edit')}}/{{$user->team_member_id}}" class="action-btn edit-btn"><i class="fa fa-file-o"></i> </a>
                                                        <a href="{{url('/dashboard/management/team/deleteTeam')}}/{{$user->team_member_id}}" class="action-btn delete-btn"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{ $users->links('pagination')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ibox">
                                <div class="ibox-title active-user-title">
                                    <span>ACTIVE USERS</span>
                                </div>
                                <div class="ibox-content active-user-content">
                                    <span class="act-num text-center">
                                        {{$count}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script src="{{url('public/js/jquery.twbsPagination.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.delete-btn').click(function(){
        if (confirm('Are you sure?')) {
            return true;
        }else{
            return false;
        }
        
    })
    // $('#header').load('../header-ads.html');
    // $('#footer').load('../footer-ads.html');
    
    // var $pagination = $('#pagination'),
    //     totalRecords = 0,
    //     records = [],
    //     displayRecords = [],
    //     recPerPage = 5,
    //     page = 1,
    //     totalPages = 0;
           
    // $.ajax({
    //     url: "",
    //     async: true,
    //     dataType: 'json',
    //     success: function (data) {
    //         records = data;
    //         console.log(records);
    //         totalRecords = records.length;
    //         totalPages = Math.ceil(totalRecords / recPerPage);
    //         apply_pagination();
    //     }
    // });
    // apply_pagination();
    // function generate_table() {
    //     var tr;
    //     $('#emp_body').html('');
    //     for (var i = 0; i < displayRecords.length; i++) {
    //         tr = $('<tr/>');
    //         tr.append("<td class='user-select'><label class='check-element'><input type='checkbox' class='check-button' name='' value=' '><i class='checkbox fa'></i><span><i class='fa fa-star'></i></span></label></td>");
    //         tr.append("<td>" + displayRecords[i].employee_salary + "</td>");
    //         tr.append("<td>" + displayRecords[i].employee_age + "</td>");
    //         $('#emp_body').append(tr);
    //     }
    // }
    // function apply_pagination() {
    //     $pagination.twbsPagination({
    //         // totalPages: totalPages,
    //         totalPages: 20,
    //         visiblePages: 4,
    //         onPageClick: function (event, page) {
    //             displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
    //             endRec = (displayRecordsIndex) + recPerPage;
    //             console.log(displayRecordsIndex + 'ssssssssss'+ endRec);
    //             displayRecords = records.slice(displayRecordsIndex, endRec);
    //             generate_table();
    //         }
    //     });
    // }
  });
</script>

@stop
