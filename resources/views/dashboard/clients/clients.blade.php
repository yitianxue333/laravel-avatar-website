@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">

 <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-7 client-individual">
                <div class="ibox-content min-size">
                    <div class="feed-activity-list">
                        <div class="assign-feed-element ">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <h3>Clients</h3>
                                    <div class="ibox-content">

                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Properties</th>
                                                    <th>Phone number</th>
                                                    <th>Active Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($clients as $client)
                                                <tr class="body-tr" onclick="location.href='{{ url('dashboard/clients/detail/'.$client->client_id) }}'">
                                                    <td class="c-tableline"># {{$client->client_id}}</td>
                                                    @if($client->use_company == -1)
                                                    <td>
                                                            <div class="avatar u-inlineBlock">
                                                                <span class="avatar-initials">{{substr($client->first_name,0,1)}}{{substr($client->last_name,0,1)}}</span>
                                                            </div>
                                                            <span class="stats-label img-circle-label select_capitalize">{{$client->first_name}}&nbsp{{$client->last_name}}</span>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <div class="avatar u-inlineBlock">
                                                            <span class="avatar-initials">{{substr($client->company,0,1)}}</span>
                                                        </div>
                                                        <span class="stats-label img-circle-label select_capitalize">{{$client->company}}</span>
                                                    </td>
                                                    @endif
                                                    <td class="c-tableline">
                                                        <span class="stats-label select_capitalize">{{$client->count}} Property</span>
                                                    </td>
                                                    <td class="c-tableline">
                                                        <span class="stats-label select_capitalize">{{$client->phone_number}}</span>
                                                    </td>
                                                    <td class="c-tableline">
                                                        <span class="stats-label select_capitalize">
                                                            @if(empty($client->interval))
                                                                Just registered
                                                            @else 
                                                                About {{$client->interval}} ago
                                                            @endif
                                                        </span>
                                                    </td>
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
                </div>
                
            </div>
           <div class="col-lg-5">
                <div class="ibox-content">
                    <div class="feed-activity-list">
                        <div class="feed-element">
                           
                            <div class="">
                                <strong>Client importing and exporting</strong>
                                @if( $permission != 3  && $permission != 4)
                               <button type="button" class="border-un pull-right btn-add" onclick="location.href='{{ url('dashboard/clients/add') }}'"><span>+Add clients</span></button>
                               @endif
                            </div>
                            
                        </div>
                        <div class="assign-feed-element">
                            <div class="row assign-right">
                                <div class="col-xs-6">
                                    <span class="stats-label">Importing an exsiting client</span>
                                </div>

                                <div class="col-xs-6" data-toggle="modal" data-target="#import-client">
                                   <button type="button" class="btn btn-w-m btn-success btn-assign"><span>Import clients</span></button>
                                </div>
                            </div>

                            <div class="row assign-right">
                                <div class="col-xs-6">
                                    <span class="stats-label">Expert your client</span>
                                </div>

                                <div class="col-xs-6" data-toggle="modal" data-target="#export-client">
                                    <button type="button" class="btn btn-w-m btn-success btn-assign" ><span>Export Clients</span></button>
                                </div>
                            </div>
                           <!--  <div class="row assign-right">
                                <div class="col-xs-6">
                                  
                                    <span class="stats-label">Sync all your clients</span>
                                </div> -->

                               <!--  <div class="col-xs-6">
                                    <button type="button" class="btn btn-w-m btn-success btn-assign"><span>Setup syncing</span></button>
                                </div> -->
                            </div>
                           <!--  <div class="row assign-right">
                                <div class="col-xs-12 ">
                                    <button class="button-assign-right">Learn More About Clients</button>
                                </div>

                            </div> -->
                        </div>       
                    </div>
                </div>
                
            </div>
        </div>

<div class="modal inmodal" id="import-client" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header-custom ">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Import Wizard</h4>
            </div>
            <div class="modal-body-custom">
                <span>Using our import wizard you can simply select a .csv (you can export this from programs like Microsoft Excel) file of your clients and do a bulk import into Jobber. Please reference our <a>sample file</a> for tips on how to format your CSV.</span>
                <br/><br>
                <span>If you have additional questions, our <a>Client List Import Documentation</a> article is a great place to start!</span>
                <br/><br>
                <input type="file" class="file">
                </div>
        </div>
    </div>

<div class="modal inmodal" id="export-client" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header-custom ">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Export Clients</h4>
            </div>
            <div class="modal-body-custom">
                <span>You can export a partial or full version of your client list. Read more about <a>Exporting Client Information.</a></span>
                <span class="div-divider"></span>
                <h4>Select tags to include in the export:</h4><br>
              <!--   <div class="tagLabel js-tagClicker ">
                    <span class="tagLabel-name js-tagLabel-name">123</span>
                    <span class="tagLabel-counter">1</span>
                </div> -->
                <em>If no tags are selected your entire client list will be exported</em>
                <br>
                <h4>Choose an export format:</h4>
                <button type="button" class="btn btn-w-m btn-white m-btn">VCard</button>
                <span>&nbsp to use with your mobile phone or address book<span>
                <br>
                <button type="button" class="btn btn-w-m btn-white m-btn">CSV</button> 
                <span>&nbsp to use with your email client or address book</span>
            </div>
        </div>
    </div>
<script src="{{url('public/js/plugins/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{url('public/js/plugins/dataTables/dataTables.bootstrap.js')}}"></script>
<script src="{{url('public/js/plugins/dataTables/dataTables.responsive.js')}}"></script>
<script src="{{url('public/js/plugins/dataTables/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript">
</script>

@stop
