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
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/croppie/croppie.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="">
            <form action="{{ url('/dashboard/management/team/updateTeam')}}" method="post">
             {{ csrf_field() }}
                <div class="col-md-12">
                @if(isset($team->team_member_id) && $team->team_member_id != '0')
                    <h1 class="headingTwo u-marginTopBig u-marginBottomBig">Edit User</h1>
                @else
                    <h1 class="headingTwo u-marginTopBig u-marginBottomBig">Add User</h1>
                @endif
                @if(isset($data['success'])) 
                  <br>
                  <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{$data['success']}}
                  </div>
                @elseif(isset($data['error']))
                  <br>
                  <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{$data['error']}}
                  </div>
                @endif
                </div>
                <div class="col-md-12 jobTypePanel">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Personal info</h3>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12 u-marginBottomSmall">
                                    <span class="profile profile-big">
                                        @if(isset($team) && $team->photo)
                                            <img src="{{url('/public/profile')}}/{{$team->photo}}" width="60" height="60">
                                        @elseif(isset($team))
                                            <?php
                                                $name_array = explode(' ', $team->fullname);
                                                for ($i = 0; $i < count($name_array); $i ++) {
                                                    if(strlen($name_array[$i]) > 0)
	                                               echo $name_array[$i][0];
                                                }
                                            ?>
                                        @else
                                            T
                                        @endif
                                    </span>
                                    <div class="upload-profile">
                                        <a class="cancelAdd-btn button--greyBlue button--ghost" tabindex="-1" href="#" data-toggle="modal" data-target="#upload_profile">Upload Photo</a>
                                    </div>
                                    <input type="hidden" name="image_name" id="image_name" value="{{isset($team)?$team->photo:''}}">
                                </div>
                                <div class="col-md-6" style="margin-top: 32px;">
                                    <input type="hidden" name="member_id" value="{{isset($team)?$team->team_member_id:'0'}}" />
                                    <div class="input-group u-grid10 u-marginBottom" id="">
                                        <input type="text" class="action-border input-lg form-control " name="fullname" value="{{isset($team)?$team->fullname:''}}" required placeholder="Full name"/>
                                    </div>
                                    <div class="input-group u-grid10 u-marginBottom" id="">
                                        <input type="email" class="action-border input-lg form-control " name="email" value="{{isset($team)?$team->email:''}}" required placeholder="Email address"/>
                                        <p class="paragraph u-textItalic">An email is required to log in to Jobber</p>
                                    </div>
                                    <div class="input-group u-grid10 u-marginBottom" id="">
                                        <input type="text" class="action-border input-lg form-control " name="phone" value="{{isset($team)?$team->phone:''}}" placeholder="Mobile phone number"/>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6 fieldGroup">
                                    <h3 class="headingTwo">Address</h3>
                                    <div class="input-group u-grid10 collapse-border" id="">
                                        <input type="text" class="action-border input-lg form-control " name="street" value="{{isset($team)?$team->street:''}}" placeholder="Street address"/>
                                    </div>
                                    <div class="input-group u-grid10 collapse-border" id="">
                                        <input type="text" class="action-border input-lg form-control " name="city" value="{{isset($team)?$team->city:''}}" placeholder="City"/>
                                    </div>
                                    <div class="input-group u-grid10 collapse-border" id="">
                                        <input type="text" class="action-border input-lg form-control " name="state" value="{{isset($team)?$team->state:''}}" placeholder="State"/>
                                    </div>
                                    <div class="input-group u-grid10 collapse-border" id="">
                                        <input type="text" class="action-border input-lg form-control u-grid5" name="zip_code" value="{{isset($team)?$team->zip_code:''}}" placeholder="Zip code"/>
                                        <label class="fa select-label label-lg u-grid5" style="float: left">
                                            <select class="input-lg form-control action-border" name="country" id="country">
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 jobTypePanel">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Permissions</h3>
                            <label class="scheduleLater">
                                <input type="checkbox" class="check-button check-admin" name="check-admin" id="check_schedule" >
                                <i class="checkbox fa"></i>
                                <span class="paragraph">
                                    Make administrator
                                </span>
                            </label>
                            <input type="hidden" name="permission" id="permission" value="{{isset($team)?$team->permission:'4'}}" />
                        </div>
                        <div class="ibox-content no-padding">
                            <div class="list-title no-border">
                                <span class="paragraph u-textItalic">
                                    What level of permissions would you like this user to have?
                                </span>
                            </div>
                            <div class="user-list">
                                <div class="row no-margin">
                                    <div class="col-md-3 u-border">
                                        <h3 class="headingTwo u-marginTop u-marginBottom">Limited Worker</h3>
                                        <p class="paragraph u-marginBottomBig" style="min-height: 80px;">Can only view schedule and location information for their assigned work.</p>
                                        <button type="button" class="assign-btn u-textBold u-marginBottom permission-btn" data-id="3">Select</button>
                                    </div>
                                    <div class="col-md-3 u-border">
                                        <h3 class="headingTwo u-marginTop u-marginBottom">Worker</h3>
                                        <p class="paragraph u-marginBottomBig" style="min-height: 80px;">Can view job details and mark visits as complete.<br>Recommended for most users.</p>
                                        <button type="button" class="assign-btn u-textBold u-marginBottom permission-btn active" data-id="4">Selected</button>
                                    </div>
                                    <div class="col-md-3 u-border">
                                        <h3 class="headingTwo u-marginTop u-marginBottom">Dispatcher</h3>
                                        <p class="paragraph u-marginBottomBig" style="min-height: 80px;">Can edit job, team, and client details. Recommended for team leads.</p>
                                        <button type="button" class="assign-btn u-textBold u-marginBottom permission-btn" data-id="5">Select</button>
                                    </div>
                                    <div class="col-md-3 u-border">
                                        <h3 class="headingTwo u-marginTop u-marginBottom">Manager</h3>
                                        <p class="paragraph u-marginBottomBig" style="min-height: 80px;">Can manage all areas excluding reports and payroll. Recommended for management.</p>
                                        <button type="button" class="assign-btn u-textBold u-marginBottom permission-btn" data-id="6">Select</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="#" class="u-floatLeft">Privacy Policy</a>
                    <a class="cancelAdd-btn button--greyBlue button--ghost" tabindex="-1" href="{{url('/dashboard/management/team')}}">Cancel</a>
                    <button name="button" type="submit" class="btn-job form-submit">Save User</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="upload_profile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Photo Uploader</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div id="upload-demo" style="width:350px"></div>
                        </div>
                        <div class="col-md-6" style="padding-top:30px;">
                            <!-- <strong>Select Image:</strong>
                            <br/> -->
                            <label class="check-element btn button--greyBlue button--ghost u-textBold u-marginTop">
                                <input type="file" id="upload" accept="image/x-png, image/jpeg"/>
                                Select Image
                            </label>
                            <button class="btn btn-job upload-result u-marginTop">Upload Image</button>
                            <p class="paragraph u-marginTop">Photo size limit is 5 megabytes.</p>
                            <p class="paragraph">File must be in JPG or PNG image format.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ url('public/js/country.js')}}"></script>
<script src="{{ url('public/js/plugins/croppie/croppie.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    populateCountries('country');

    @if(isset($team))
        $('#country').children('option[value={{isset($team)?$team->country:'0'}}]').attr('Selected', true);
        $('.permission-btn').text('Select');
        $('.permission-btn').removeClass('active');
        $('button[data-id="{{isset($team)?$team->permission:''}}"]').text('Selected');
        $('button[data-id="{{isset($team)?$team->permission:''}}"]').addClass('active');

        @if($team->permission == 2)
            $('.user-list').hide();
            $('#check_schedule').attr('checked', true);
        @endif
    @endif
    $('.check-admin').change(function(){
        if($(this).prop('checked') == true){
            $('#permission').val(2);
            $('.user-list').hide();
        }else{
            $('.permission-btn').text('Select');
            $('.permission-btn').removeClass('active');
            $('.user-list').show();
        }
    });
    $('.permission-btn').click(function(){
        $('.permission-btn').text('Select');
        $('.permission-btn').removeClass('active');
        $(this).text('Selected');
        $(this).addClass('active');
        var permission = $(this).attr('data-id');
        // console.log(permission);
        $('#permission').val(permission);
    });

  });
  
</script>
<script type="text/javascript">

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#upload').on('change', function () { 
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                url: "{{url('dashboard/management/team/uploadPhoto')}}",
                type: "POST",
                data: {

                    '_token': $('input[name=_token]').val(),
                    'id': {{isset($team)?$team->team_member_id:'0'}},
                    "image":resp
                },
                success: function (data) {
                    console.log(data.image_name);
                    if (data.success == 'done') {
                        html = '<img src="' + resp + '" width="60px" height="60px"/>';
                        $(".profile-big").text('');
                        $(".profile-big").html('');
                        $(".profile-big").html(html);
                        $('#upload_profile').modal('hide');
                        $('#image_name').val(data.image_name);
                    }
                }
            });
        });
    });

</script>

@stop
