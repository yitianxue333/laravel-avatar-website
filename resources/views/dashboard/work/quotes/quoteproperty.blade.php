@extends('layout.menu')
@section('content')
<link href="{{ url('public/css/workcustom.css')}}" rel="stylesheet">
<div class="quote-property">
    <div class="row">
        <div class="col-md-12">
            <div class="new-quote-content bounceInRight">
                <div class="new-quote-header">
                    <h1 class="header-title headingTwo text-left">New Quotes</h1>
                </div>
                <div class="new-quote-body">
                    <p class="paragraph u-marginBottomSmall">
                        Which client would you like to create this quote for?
                    </p>
                    <div class="ibox clientbox">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="">
                                        <!-- <label class="fa search-label"> -->
                                        <form>
                                            <input type="search" placeholder="Search properties..." id="searchquotes" 
                                            class="search-input action-border" required>
                                            <!-- <button class="close-icon" type="reset">
                                                ×
                                            </button> -->
                                        </form>
                                        <!-- </label> -->
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{url('dashboard/properties/newproperty')}}/{{$client_id}}" type="button" class="btn btn-newclient creteNew u-textBold" remote="true">+ Create New Property</a>
                                    <span class="middle-text">Or</span>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="thicklist row_holder ">  
                            @foreach ($properties as $property)
                                <a href="{{url('dashboard/work/quotes/add')}}/{{$property->client_id}}/{{$property->property_id}}" filter-value="{{$property->street1}} {{$property->street2}} {{$property->city}} {{$property->state}}">
                                    <div class="thicklist-row client js-spinOnClick">
                                        <input type="hidden" name="clientId" id="clientId" value="1" />
                                        <div class="row">
                                            <div class="columns col-sm-12">
                                                <p class="paragraph">{{$property->street1}} {{$property->street2}} {{$property->city}} {{$property->state}}
                                                <span class="pull-right">
                                                    <i class="fa fa-2x fa-angle-right"></i>
                                                </span>
                                                </p>
                                            </div>

                                        </div>
                                    </div>  
                                </a>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var inputId     = 'searchquotes';
    var itemsData   = 'filter-value';
    var displaySet = false;
    var displayArr = [];

    function getDisplayType(element) {
        var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
        return elementStyle.display;
    }

    document.getElementById(inputId).onkeyup = function() {
        $('#invoicelist > h3').hide();
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
</script>
@stop