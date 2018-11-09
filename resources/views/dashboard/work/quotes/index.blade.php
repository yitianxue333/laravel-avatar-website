@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
		<div class="page-heading">
            <div class="col-sm-4 page-header-title">
                <h1>Quotes</h1>
            </div>
            @if( $permission == 1 || $permission == 2 || $permission == 6)
            <a data-toggle="modal" href="#modal-newquotes" class="btn btn-new">+ New Quotes</a>
            @endif
            <div class="modal inmodal" id="modal-newquotes" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
                    </div>
                    <div class="modal-body">
                        <p class="paragraph u-marginBottomSmall">
                            Which client would you like to create this quote for?
                        </p>
                        <div class="ibox clientbox">
                            <div class="ibox-title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <form>
                                                <input type="search" id="searchclients" placeholder="Search Clients..."
                                                class="search-input action-border" required />
                                                <!-- <button class="close-icon" type="reset">
                                                    ×
                                                </button> -->
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{url('dashboard/clients/add')}}" type="button" class="btn btn-newclient creteNew u-textBold" remote="true">+ Create New Client</a>
                                        <span class="middle-text">Or</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="thicklist row_holder ">
                                <ul id="clientlist">
                                @foreach ($clients as $client)
                                    <li filter-client="{{$client->first_name}} {{$client->last_name}}">
                                    <a href="{{url('dashboard/work/quotes/newquote/')}}/{{$client->client_id}}">
                                        <div class="thicklist-row client js-spinOnClick">
                                            <input type="hidden" name="clientId" id="clientId" value="1" />

                                            <div class="row">
                                                <div class="columns col-sm-1 text-center">
                                                    <i class="fa fa-2x fa-user green-tag"></i>
                                                </div>
                                                <div class="columns col-sm-6">
                                                    <h3 class="headingFive u-marginTopSmallest"> {{$client->first_name}} {{$client->last_name}}</h3>
                                                    <small>
                                                        {{$client->count}} Properties
                                                        @if($client->phone)
                                                        | {{$client->phone}}
                                                        @endif
                                                    </small>
                                                </div>

                                                <div class="columns col-sm-5 text-right">
                                                    @if($client->diffday)   
                                                    <small>Activity about {{$client->diffday}} days ago</small>
                                                    @elseif($client->diffhour)
                                                    <small>Activity about {{$client->diffhour}} hours ago</small>
                                                    @elseif($client->diffmin)
                                                    <small>Activity about {{$client->diffmin}} mins ago</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    </li>
                                @endforeach
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="ibox">
                    <div class="ibox-title quotes-toolbar">
                        <div class="row">
                        	<div data-count="1" class="count type_filter"></div>
                            <div class="col-md-3">
                                <div class="input-group">
                                	<!-- <label class="fa search-label"> -->
                                	<form>
                                		<input type="search" id="searchquotes" placeholder="Search quotes..."
                                		class="search-input action-border" ></input>
                                		<!-- <button class="close-icon" type="reset">
                                			×
                                		</button> -->
                                	</form>
                                	<!-- </label> -->
                                </div>
                            </div>
                            <div class="col-md-9">
                            	<div class="row">
                            		<div class="col-md-4">
                            			<label class="card-headerFieldLabel" for="status_filter">
										    Status
										 </label>
                            			<label class="fa select-label">
                            				<select class="show-option action-border status-select">
                            					<option value="1" <?php echo $filter_status == 1? "selected" : "" ;?>>All</option>
                            					<option value="2" <?php echo $filter_status == 2? "selected" : "" ;?>>Last 30 days</option>
                            					<option value="3" <?php echo $filter_status == 3? "selected" : "" ;?>>This month</option>
                            					<option value="4" <?php echo $filter_status == 4? "selected" : "" ;?>>Last month</option>
                            					<option value="5" <?php echo $filter_status == 5? "selected" : "" ;?>>This year</option>
                            					<option value="6" <?php echo $filter_status == 6? "selected" : "" ;?>>Custom</option>
                            				</select>
                            			</label>
                            		</div>
                            		<div class="col-md-4">
                            			<label class="card-headerFieldLabel" for="order_by">
										    Sort
										 </label>
                            			<label class="fa select-label">
                            				<select class="show-option action-border" id="sort-select" onchange="sort_quotes(this)">
                            					<option value="status">Status</option>
                            					<option value="quotenum">Quotes number</option>
                            					<option value="firstname">First name</option>
                                                <option value="lastname">Last name</option>
                            					<option value="rating">Star rating</option>
                            				</select>
                            			</label>
                            		</div>
                            		<div class="col-md-4">
                            			<label class="card-headerFieldLabel" for="type_filer">
										    Type
										 </label>
                            			<label class="fa select-label">
                            				<select class="show-option action-border type-select">
                            					<option value="1" <?php echo $filter_type == 1 ? "selected" : "" ;?>>All</option>
                                      <option value="2" <?php echo $filter_type == 2 ? "selected" : "" ;?>>Draft</option>
                                      <option value="3" <?php echo $filter_type == 3 ? "selected" : "" ;?>>Awaiting response</option>
                                      <option value="4" <?php echo $filter_type == 4 ? "selected" : "" ;?>>Change request</option>
                                      <option value="5" <?php echo $filter_type == 5 ? "selected" : "" ;?>>Approved</option>
                            					<option value="6" <?php echo $filter_type == 6 ? "selected" : "" ;?>>Converted</option>
                            					<option value="7" <?php echo $filter_type == 7 ? "selected" : "" ;?>>Archived</option>
                            				</select>
                            			</label>
                            		</div>
                            	</div>
                                <div class="row custom-daterange" style="<?php echo $filter_status != 6  ? "display: none;" : "" ;?>">
                                    <div class="col-md-12">
                                        <div class="input-daterange input-group" id="daterange">
                                            <label class="card-headerFieldLabel" for="">
                                                From
                                            </label>
                                            <div class="input-group date" id="start_date">
                                                <input type="text" class="action-border form-control input-group-addon text-center" name="start_date" value="<?php echo $start_date == 0 ? date('Y-m-01'): $start_date;?>" />
                                            </div>
                                            <span class="input-group-addon daterangemiddle"></span>
                                            <label class="card-headerFieldLabel" for="">
                                                To
                                            </label>
                                            <div class="input-group date" id="end_date">
                                                <input type="text" class="action-border form-control input-group-addon text-center" name="end_date"  value="<?php echo $end_date == 0 ? date('Y-m-t'): $end_date;?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content quotes-content">
						<div class="thicklist row_holder " style="min-height: 445px;">
                            <ul id="quotelist">
                                @if(count($drafts))
                                    <h3 class="thicklist-sectionHeader grey-tag">Draft</h3>
                                    @foreach($drafts as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}}" quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
                                        <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
                                            <div class="row">
                                                <div class="large-expand columns col-sm-3">
                                                    <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
                                                    <div class="inlineLabel inlineLabel--grey font-p11"><span>DRAFT</span></div>
                                                </div>

                                                <div class="columns col-sm-3">
                                                    <small>
                                                        <strong>Created On</strong>
                                                        <br>
                                                        <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                    </small>
                                                </div>

                                                <div class="columns col-sm-3">
                                                    <div class="row">
                                                        <span class="thicklist-text">
                                                        @if(isset($quote->street1) || isset($quote->street2))
                                                        {{$quote->street1}} {{$quote->street2}}<br>
                                                        @endif
                                                        {{$quote->city}}, {{$quote->state}}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="columns col-sm-3 text-right">
                                                    <div class="col-md-12">
                                                        <span class="thicklist-price">
                                                        <p class="total-value pull-right">${{$quote->total}}</p>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class='rating-stars pull-right text-right'>
                                                            <ul id='stars'>
                                                            @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                              <li class='star selected' >
                                                                <i class='fa fa-star'></i>
                                                              </li>
                                                            @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--row-->
                                        </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($awaitings))
        					        <h3 class="thicklist-sectionHeader orange-tag">Awaiting Response</h3>
                                    @foreach($awaitings as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}}" quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
        						    <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
        							    <div class="row">
        							        <div class="large-expand columns col-sm-3">
        							            <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
        							          <div class="inlineLabel inlineLabel--orange font-p11"><span>AWAING RESPONSE</span></div>
        							        </div>

        						        	<div class="columns col-sm-3">
                                                <small>
                                                    <strong>Created On</strong>
                                                    <br>
                                                        <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                </small>
                                            </div>

        							        <div class="columns col-sm-3">
        							            <div class="row">
        						                    <span class="thicklist-text">
                                                    @if(isset($quote->street1) || isset($quote->street2))
                                                    {{$quote->street1}} {{$quote->street2}}<br>
                                                    @endif
                                                    {{$quote->city}}, {{$quote->state}}
                                                    </span>
            							        </div>
        							        </div>

        							        <div class="columns col-sm-3 text-right">
                                                <div class="col-md-12">
                                                    <span class="thicklist-price">
                                                    <p class="total-value pull-right">${{$quote->total}}</p>
                                                    </span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class='rating-stars pull-right text-right'>
                                                        <ul id='stars'>
                                                        @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                          <li class='star selected' >
                                                            <i class='fa fa-star'></i>
                                                          </li>
                                                        @endfor
                                                        </ul>
                                                    </div>
                                                </div>
        							        </div>
        							    </div><!--row-->
        						    </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($changes))
                                    <h3 class="thicklist-sectionHeader red-tag">Change requested</h3>
                                    @foreach($changes as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}} " quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
                                    <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--red font-p11"><span>CHANGE REQUESTED</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>Created On</strong>
                                                    <br>
                                                    <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">
                                                        @if(isset($quote->street1) || isset($quote->street2))
                                                        {{$quote->street1}} {{$quote->street2}}<br>
                                                        @endif
                                                        {{$quote->city}}, {{$quote->state}}
                                                    </span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <div class="col-md-12">
                                                    <span class="thicklist-price">
                                                    <p class="total-value pull-right">${{$quote->total}}</p>
                                                    </span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class='rating-stars pull-right text-right'>
                                                        <ul id='stars'>
                                                        @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                          <li class='star selected' >
                                                            <i class='fa fa-star'></i>
                                                          </li>
                                                        @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($approveds))
                                    <h3 class="thicklist-sectionHeader green-tag">Approved</h3>
                                    @foreach($approveds as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}} " quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
                                    <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--green font-p11"><span>APPROVED</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>Created On</strong>
                                                    <br>
                                                    <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                <span class="thicklist-text">
                                                @if(isset($quote->street1) || isset($quote->street2))
                                                {{$quote->street1}} {{$quote->street2}}<br>
                                                @endif
                                                {{$quote->city}}, {{$quote->state}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <div class="col-md-12">
                                                    <span class="thicklist-price">
                                                    <p class="total-value pull-right">${{$quote->total}}</p>
                                                    </span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class='rating-stars pull-right text-right'>
                                                        <ul id='stars'>
                                                        @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                          <li class='star selected' >
                                                            <i class='fa fa-star'></i>
                                                          </li>
                                                        @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($converts))
                                    <h3 class="thicklist-sectionHeader blue-tag">Converted</h3>
                                    @foreach($converts as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}}" quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
                                    <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--blue font-p11"><span>CONVERTED</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>Created On</strong>
                                                    <br>
                                                    <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">
                                                    @if(isset($quote->street1) || isset($quote->street2))
                                                    {{$quote->street1}} {{$quote->street2}}<br>
                                                    @endif
                                                    {{$quote->city}}, {{$quote->state}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <div class="col-md-12">
                                                    <span class="thicklist-price">
                                                    <p class="total-value pull-right">${{$quote->total}}</p>
                                                    </span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class='rating-stars pull-right text-right'>
                                                        <ul id='stars'>
                                                        @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                          <li class='star selected' >
                                                            <i class='fa fa-star'></i>
                                                          </li>
                                                        @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($archives))
                                    <h3 class="thicklist-sectionHeader black-tag">Archived</h3>
                                    @foreach($archives as $quote)
                                    <li filter-value="{{$quote->first_name}} {{$quote->last_name}} " quotenum="{{$quote->quote_id }}" firstname="{{$quote->first_name}}" lastname="{{$quote->last_name}}" rating="{{$quote->rate_opportunity}}">
                                    <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="headingFive u-marginBottomSmallest">#{{$quote->quote_id}} : {{$quote->first_name}} {{$quote->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--black font-p11"><span>ARCHIVED</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>Created On</strong>
                                                    <br>
                                                    <?php $date = date_create($quote->created_at)?>
                                                        {{date_format($date ,'Y-m-d')}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">
                                                        @if(isset($quote->street1) || isset($quote->street2))
                                                        {{$quote->street1}} {{$quote->street2}}<br>
                                                        @endif
                                                        {{$quote->city}}, {{$quote->state}}
                                                    </span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <div class="col-md-12">
                                                    <span class="thicklist-price">
                                                    <p class="total-value pull-right">${{$quote->total}}</p>
                                                    </span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class='rating-stars pull-right text-right'>
                                                        <ul id='stars'>
                                                        @for($i = 0 ; $i < $quote->rate_opportunity; $i++)
                                                          <li class='star selected' >
                                                            <i class='fa fa-star'></i>
                                                          </li>
                                                        @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
        		<div class="ibox">
        			<div class="ibox-title jbox-title headingFour">
        				<span>Quotes Overview</span>
        			</div>
        			<div class="ibox-content jbox-content">
                        @if($counts[0]->draftnum)
        				<div class="row">
	        				<div class=" col-md-3">
	        					<a href="{{url('dashboard/work/quotes')}}?status=1&type=2" class="btn-lg upcoming-num inlineLabel--grey"><strong>{{$counts[0]->draftnum}}</strong></a>
	        				</div>
	        				<div class=" col-md-9">
	        					<a href=""><h4 class="headingFive">Draft</h4></a>
	        					<p>Ready to be sent.</p>
	        				</div>
        				</div>
                        @endif
                        @if($counts[0]->awaitingnum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/quotes')}}?status=1&type=3" class="btn-lg upcoming-num inlineLabel--orange"><strong>{{$counts[0]->awaitingnum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Awaiting Response</h4></a>
                                <p>Sent to the client,but waiting to hear back.</p>
                            </div>
                        </div>
                        @endif
                        @if($counts[0]->changenum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/quotes')}}?status=1&type=4" class="btn-lg upcoming-num inlineLabel--red"><strong>{{$counts[0]->changenum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Change requested</h4></a>
                                <p>Clients has requested changes.</p>
                            </div>
                        </div>
                        @endif
                        @if($counts[0]->approvednum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/quotes')}}?status=1&type=5" class="btn-lg upcoming-num inlineLabel--green"><strong>{{$counts[0]->approvednum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Approved</h4></a>
                                <p>Ready to be converted to jobs.</p>
                            </div>
                        </div>
                        @endif
                        @if($counts[0]->convertnum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/quotes')}}?status=1&type=6" class="btn-lg upcoming-num inlineLabel--blue"><strong>{{$counts[0]->convertnum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Converted</h4></a>
                                <p>Converted to jobs.</p>
                            </div>
                        </div>
                        @endif
                        @if($counts[0]->archivenum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/quotes')}}?status=1&type=7" class="btn-lg upcoming-num inlineLabel--black"><strong>{{$counts[0]->archivenum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Archive</h4></a>
                                <p>Not converted to jobs.</p>
                            </div>
                        </div>
                        @endif
        			</div>
        		</div>
                <!-- <div class="ibox">
                    <div class="ibox-title jbox-title headingFour">
                        <span>Quotes for offline use</span>
                    </div>
                    <div class="ibox-content jbox-content">
                        <a target="_blank" class="printquote-btn m-b" href="#">Print Blank Quotes</a>
                        <a target="_blank" class="downloadquote-btn" href="#">Download Blank Quotes</a>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-title jbox-title headingFour">
                        <span>Help and documentation</span>
                    </div>
                    <div class="ibox-content jbox-content">
                        <a target="_blank" class="learnmore-btn" href="#">Learn More About quotes</a>
                    </div>
                </div> -->
            </div>
        </div>

<script type="text/javascript">
    $(document).ready(function(){
        // $('#start_date').datepicker({
        //     format: 'yyyy-mm-dd',
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

        $('#daterange').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('.status-select').on('change',function(){
            // $('#quotelist > h3').show();
            var start_date = $('#start_date input').val();
            var end_date = $('#end_date input').val();
            var status = $(this).val();
            var type = $('.type-select').val();
            if (status == 6) {
                $('.custom-daterange').css('display','block');
                location.href = "{{url('dashboard/work/quotes')}}?status="+status+"&type="+type+"&start_date="+start_date+"&end_date="+end_date;
            }else{
                location.href = "{{url('dashboard/work/quotes')}}?status="+status+"&type="+type;
            }
        });
        $('.type-select').on('change',function(){
            // $('#quotelist > h3').show();
            var type = $(this).val();
            var start_date = $('#start_date input').val();
            var end_date = $('#end_date input').val();
            var status = $('.status-select').val();
            if (status == 6) {
                $('.custom-daterange').css('display','block');
                location.href = "{{url('dashboard/work/quotes')}}?status="+status+"&type="+type+"&start_date="+start_date+"&end_date="+end_date;
            }else{
                location.href = "{{url('dashboard/work/quotes')}}?status="+status+"&type="+type;
            }
        });
    });
    $('.type_filter').html($('.quotes-content .thicklist #quotelist > li').length+' quotes');
</script>
<script>
    var inputId     = 'searchquotes';
    var itemsData   = 'filter-value';
    var displaySet = false;
    var displayArr = [];

    function getDisplayType(element) {
        var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
        return elementStyle.display;
    }

    document.getElementById(inputId).onkeyup = function() {
        $('#quotelist > h3').hide();
        var searchVal = this.value.toLowerCase();
        var filterItems = document.querySelectorAll('[' + itemsData + ']');
        for(var i = 0; i < filterItems.length; i++) {
            if (!displaySet) {
                displayArr.push(getDisplayType(filterItems[i]));
            }

            filterItems[i].style.display = 'none';

            if(filterItems[i].getAttribute('filter-value').toLowerCase().indexOf(searchVal) >= 0) {
                filterItems[i].style.display = displayArr[i];
            }
        }

        displaySet = true;
    }

    var inputclientId     = 'searchclients';
    var itemsclientData   = 'filter-client';
    var displayclient = false;
    var displayclientArr = [];

    function getDisplayclientType(element) {
        var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
        return elementStyle.display;
    }

    document.getElementById(inputclientId).onkeyup = function() {
        var searchvalclient = this.value.toLowerCase();
        var filterclientItems = document.querySelectorAll('[' + itemsclientData + ']');
        for(var i = 0; i < filterclientItems.length; i++) {
            if (!displayclient) {
                displayclientArr.push(getDisplayclientType(filterclientItems[i]));
            }

            filterclientItems[i].style.display = 'none';

            if(filterclientItems[i].getAttribute('filter-client').toLowerCase().indexOf(searchvalclient) >= 0) {
                filterclientItems[i].style.display = displayclientArr[i];
            }
        }

        displayclient = true;
    }

    function sort_quotes(ele) {
    $('#quotelist > h3').hide();
    var container = document.getElementById("quotelist");
    var selectBox = ele.value;
    var elements = container.childNodes;
    var sortMe = [];

    var sortItems = document.querySelectorAll('['+ selectBox +']');
    for(var i=0; i<sortItems.length; i++){
            sortMe.push([sortItems[i].getAttribute(selectBox).toUpperCase(), sortItems[i] ]);
    }

    sortMe.sort();
    for (var i=0; i<sortMe.length; i++) {
        container.appendChild(sortMe[i][1]);
    }

}
</script>
@stop
