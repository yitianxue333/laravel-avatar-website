@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/services.css')}}">
<div class="col-md-12">
  <form method="post" class="form-horizontal">
    {{ csrf_field() }} 
    <div class="ibox">
        <div class="ibox-title">
            <h2 class="headingTwo">Services & Products</h2>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <p class="paragraph">Add and update your services and products to stay organized when creating quotes, jobs, and invoices.</p>
                </div>
                @if(isset($success)) 
                  <br><br>
                  <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      {{ $success }}
                    </div>
                  </div>
                @endif
                <div class="col-md-12">
                  <div class='alarm-block'>
                    <div class='row'>
                      <div class='col-sm-1 block-left'><i class="fa fa-unlink fa-3x"></i></div>
                      <div class='col-sm-11 block-right'>
                        <div class='block-title'>Need to change the order of products and services?</div>
                        <div class='block-body'>Drag to rearrange the order that items show up in Jobber</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 jobTypePanel" id="service_table">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo col-md-8">Services</h3>
                            <div class='col-md-4 pull-right text-right'>
                              <button type='button' class='btn btn-sm btn-default btn-sort' data-type='service'>Save Sort</button>
                              <a href="{{ route('service.add') }}" class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Add Service</a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                          <ul id="sortable_service" class="service_table">
                            @foreach($services as $service)
                              <li data-id="{{$service->service_id}}">
                                <div class='row'>
                                  <div class='col-sm-12 col-md-4'><a href="{{ route('service.edit', ['id' => $service->service_id]) }}">{{$service->name}}</a></div>
                                  <div class='col-sm-12 col-md-8'>{{$service->description}}</div>
                                </div>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12 jobTypePanel" id="product_table">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo col-md-8">Products</h3>
                            <div class='col-md-4 pull-right text-right'>
                              <button type='button' class='btn btn-sm btn-default btn-sort' data-type='product'>Save Sort</button>
                              <a href="{{ route('product.add') }}" class='btn btn-sm btn-primary'><i class='fa fa-plus'></i> Add Product</a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                          <ul id="sortable_product" class="service_table">
                            @foreach($products as $product)
                              <li data-id="{{$product->service_id}}">
                                <div class='row'>
                                  <div class='col-sm-12 col-md-4'><a href="{{ route('product.edit', ['id' => $product->service_id]) }}">{{$product->name}}</a></div>
                                  <div class='col-sm-12 col-md-8'>{{$product->description}}</div>
                                </div>
                              </li>
                            @endforeach
                          </ul>
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