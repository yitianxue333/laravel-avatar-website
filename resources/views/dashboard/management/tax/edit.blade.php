@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/services.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/iCheck/custom.css')}}">
<script src="{{ url('public/js/plugins/iCheck/icheck.min.js')}}"></script>
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo">Tax</h2>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    @if(isset($success)) 
                      <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{$success}}
                      </div>
                    @endif
                </div>
                <div class="col-md-12 jobTypePanel" id="service_table">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Tax Info</h3>
                        </div>
                        <div class="ibox-content no-padding">
                          <form method="post" class="form-horizontal">
                            {{ csrf_field() }}  
                            <br>
                            <div class="form-group">
                                <label for='name' class="col-sm-3 control-label">Tax Name</label>
                                <div class="col-sm-7">
                                  <input type='text' id='name' name='name' value='{{ $name }}' class='form-control' autocomplete='off' placeholder='Name' required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label for='rate' class="col-sm-3 control-label">Tax Rate</label>
                                <div class="col-sm-7">
                                  <div class="input-group">
                                    <div class="input-group"><span class="input-group-addon">&nbsp;&nbsp;$&nbsp;&nbsp;</span>
                                      <input type="text" name='rate' id='rate' value='{{ $rate }}' class="form-control" placeholder='0.00' required>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label for='description' class="col-sm-3 control-label">Internal Description</label>
                                <div class="col-sm-7">
                                  <textarea id='description' name='description' class='form-control' placeholder='Description'>{{ $description }}</textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label for='is_default' class="col-sm-3 control-label"></label>
                                <div class="col-sm-7">
                                  <div class="checkbox i-checks"><label style='padding-left:0px'> <input type="checkbox" name="is_default" id="is_default" value="1" {{ $is_default == 1 ? 'checked' : '' }}> <i></i> Use Default </label></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right"></div>
                                <div class="col-sm-7 text-right">
                                  <a href="{{ route('tax.index') }}" class="btn btn-default">Cancel</a>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Tax</button>
                                </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('#btn-delete').click(function() {
      if(!confirm('Are you sure you want to delete this product?')) {
        return;
      }

      $('form').attr('action', "{{ route('services.delete', ['id' => $id]) }}");
      $('form').submit();
    });
  });
</script>
@stop