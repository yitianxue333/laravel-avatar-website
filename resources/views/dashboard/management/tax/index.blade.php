@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/services.css')}}">
<div class="col-md-12">
  <form method="post" class="form-horizontal">
    {{ csrf_field() }} 
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo">Taxes</h2>
        </div>
        <div class="ibox-content">
            <div class="row">
                @if(isset($success)) 
                  <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      {{ $success }}
                    </div>
                  </div>
                @endif
                <div class="col-md-12 jobTypePanel" id="service_table">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo col-md-8">Tax List</h3>
                            <div class='col-md-4 pull-right text-right'>
                              <a href="{{ route('tax.add') }}" class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Add Tax</a>
                            </div>
                        </div>
                        <div class="ibox-content">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                  <th>Tax Name</th>
                                  <th>Tax Rate</th>
                                  <th>Internal Description</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              @foreach($taxes as $one)
                                <tr>
                                  <td>{{ $one->name }} {{ $one->is_default == 1 ? '(default)' : '' }}</td>
                                  <td>{{ $one->value }}</td>
                                  <td>{{ $one->description }}</td>
                                  <td class="text-right"><a href="{{ route('tax.edit', ['id'=>$one->tax_id]) }}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> edit</a></td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type='hidden' name='type' value=''>
    <input type='hidden' name='sort_value' value=''>
  </form>
<script type="text/javascript">
  $(document).ready(function(){
    $('#sortable_service, #sortable_product').sortable();

    $('.btn-sort').click(function() {
      $this = $(this);
      $type = $this.attr('data-type');

      $sort_value = '';
      $('#sortable_' + $type + ' li').each(function() {
        $sort_value += $sort_value == '' ? $(this).attr('data-id') : ',' + $(this).attr('data-id');
      });

      
      $('input[name="type"]').val($type);
      $('input[name="sort_value"]').val($sort_value);

      $('form').attr('action', "{{ route('services.sortall') }}");
      $('form').submit();
    });
  });
</script>
@stop