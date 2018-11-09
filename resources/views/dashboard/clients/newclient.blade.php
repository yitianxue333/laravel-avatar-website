@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<div class="wrapper wrapper-content">
    <form role="search" class="" method="post" action="{{route('clients.create')}}">
    {{ csrf_field() }}  
        <div class="client-container">
            <!-- <div class="row container"> -->
                <div class="col-lg-12 client ">
                    <div class="ibox-content">
                        <div class=" row ibox-content-title">
                                <span class="badge badge-primary "><i class="fa fa-3x fa-user"></i></span>
                                <span class="title">Clients details</span>
                        </div>
                        <div class="ibox-content-body">

                            <div class="body-auth">
                                <div class="row show-grid auth">
                                    <div class="col-md-6 focus-state">
                                        <input type="text" name="clientFname" placeholder="First name" class="form-control" >
                                    </div>
                                    <div class="col-md-6 focus-state">
                                        <input type="text" name="clientLname"placeholder="Last name" class="form-control" >
                                    </div>
                                </div>
                                <div class="row show-grid auth">
                                    <div class="col-md-12 focus-state">
                                        <input type="text" name="companyname" placeholder="Company name" class="form-control" >
                                    </div>
                                </div><br/>
                                <div class="checkbox i-checks auth">
                                    <label>
                                    <input type="checkbox" value=""> <i></i> <h4>Use company name as the primary    name <h4>
                                    </label>
                                </div>  
                            </div>


                            <div class="body-contact">
                                <h3> Contact detail</h3><br/>
                                <div class="input-group-contact m-b pho-num">
                                    <div class="col-md-3 contact-select focus-state">
                                        <select class="form-control m-b" name="contactPkind">
                                            <option value="main"><h4>Main</h4></option>
                                            <option value="work"><h4>Work</h4></option>
                                            <option value="mobile"><h4>Mobile</h4></option>
                                            <option value="home"><h4>Home</h4></option>
                                            <option value="fax"><h4>Fax</h4></option>
                                            <option value="other"><h4>Other</h4></option>
                                         </select>                                    
                                    </div>
                                    <div class="col-md-9 contact-select focus-state">
                                        <input type="text" class="form-control" name="phonenumber">
                                    </div><br>
                                    
                                </div>
                                <div class="create-info">
                                    <a id="phone" onClick="addinfo(this)">Add Another Phone Number</a>
                                </div>
                                <div class="input-group-contact m-b eml-add focus-state">
                                    <div class="col-md-3 contact-select">
                                        <select class="form-control m-b" name ="contactEkind">
                                            <option value="main"><h4>Main</h4></option>
                                            <option value="work"><h4>Work</h4></option>
                                            <option value="mobile"><h4>Mobile</h4></option>
                                            <option value="home"><h4>Home</h4></option>
                                            <option value="fax"><h4>Fax</h4></option>
                                            <option value="other"><h4>Other</h4></option>
                                         </select>                                    
                                    </div>
                                    <div class="col-md-9 contact-select focus-state" >
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                    <br>
                                    
                                </div>
                                <div class="create-info">
                                        <a  id="email" onClick="addinfo(this)">Add Another Email Address</a>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                    <div class="ibox ibox-content property property-add">
                        <div class="row ibox-content-title">
                                <span class="badge badge-primary "><i class="fa fa-3x fa-home"></i></span>
                                <span class="title">Property details</span>
                        </div>   
                        <div class="ibox-content-body">

                            <div class="body-auth">
                                <div class="row show-grid auth">
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="street1" class="form-control">
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="street2" class="form-control">
                                    </div>
                                    <div class="input-group-contact m-b ">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="city" placeholder="City"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" name="state" placeholder="State"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="zipcode" class="form-control">
                                        </div>
                                        <div class="col-md-6 country-select focus-state">
                                            <select class="form-control auth-country" name="country" id="countryfirst">
                                             </select>                                    
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                        <div class="tax-label">
                            <h4>Taxs</h4>
                        </div>
                        <div class="btn-group tax-dropbox-group">
                            <a data-toggle="dropdown" class="dropdown-toggle display-tax">tax1 (0.2%) (Default)</a>
                            <ul class="dropdown-menu tax-dropmenu">
                                <li>
                                <label class="cursor-pointer">
                                    <div class="tax-dropdown">
                                        <input type="radio"  id="taxRadios1" data-name="tax1 (0.2%) (Default)"      class="dropdown-radio" name="taxradio" checked="checked">
                                        <span>tax1 (0.2%) (Default)</span>
                                    </div>
                                 </label>
                                </li>
                                <li>
                                <label class="cursor-pointer">
                                    <div class="tax-dropdown">
                                        <input type="radio"  id="taxRadios2" data-name="tax2 (0.4%)"            class="dropdown-radio" name="taxradio">
                                        <span>tax2 (0.4%)</span>
                                    </div>
                                </label>
                                </li>
                                <li>
                                <label class="cursor-pointer">
                                    <div class="tax-dropdown">
                                        <input type="radio" id="taxRadios3"     data-name="tax3 (0.5%)"     class="dropdown-radio" name="taxradio">
                                        <span>tax3 (0.5%)</span>
                                    </div>
                                </label>
                                </li>
                            </ul>
                        </div>


                            <div class="checkbox i-checks auth">
                                <label>
                                <input id="billing" type="checkbox" checked="checked"> <i></i> <h4>Billing address is the same as   property address<h4>
                                </label>
                            </div>
                            <div class="body-auth billing">
                                <div class="row show-grid auth">
                                    <h4>Billing address</h4>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="Bstreet1" class="form-control">
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="Bstreet2" class="form-control">
                                    </div>
                                    <div class="input-group-contact m-b">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="Bcity" placeholder="City"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" name="Bstate" placeholder="State"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="Bzipcode" class="form-control">
                                        </div>
                                        <div class="col-md-6  focus-state billing-country country-select">
                                                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>            
                    </div>
                    <div class="ibox-content blank-btn-area">
                        <div class="button-area">
                            <button type="submit" class="pull-right btn btn-w-m btn-warning btn-area">Create Client</button>
                            <button type="button" class="pull-right btn btn-w-m btn-white btn-area">Cancel</button>
                        </div>
                    </div>
                </div>   
        </div>
    </form>   
    
</div>
<script src="{{ url('public/js/country.js')}}"></script>
<script>
    function addinfo(ele){
        var spaceid ="space-".concat(ele.id);
        var element = document.getElementById(spaceid);
        // alert($(ele).parent().);
        ele.parentElement.innerHTML = "<div class='new input-group-contact m-b '><div class='col-md-1 contact-select '><input class='checkbox i-checks adding-radio' type='radio' name='link-radio'></div> <div class='col-md-3 contact-select'><select class='form-control m-b'><option value='main'><h4>Main</h4></option> <option value='work'><h4>Work</h4></option> <option value='mobile'><h4>Mobile</h4></option> <option value='home'><h4>Home</h4></option> <option value='fax'><h4>Fax</h4></option> <option value='other'><h4>Other</h4></option> </select> </div> <div class='col-md-7 contact-select'> <input type='text' class='form-control'> </div><div class='col-md-1'><i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i></div><br></div><div class='create-info'><a  id='email' onClick='addinfo(this)'>Add Another Email Address</a></div>";
    }
    
    populateCountries('countryfirst');
    // populateCountries('countrybilling');

    $(document).ready(function(){

        $('.auth-country').clone().appendTo('.billing-country');

        $('#billing').change(function(){
            var input = $(this);
            if(input.is(':checked')){
                $('.billing').fadeOut('fast');
            }
            else
                $('.billing').fadeIn('fast');
        });

        $('.tax-dropmenu').click(function(){
            
        });


        
    });
    function displayTaxVals() {
      var singleValues = $( "input[name = taxradio]:checked" ).attr('data-name');
      console.log(singleValues);
      $( ".display-tax" ).html(  singleValues );
    }

    $( "input[name = taxradio]:radio" ).click( displayTaxVals );

    displayTaxVals();

    // $('input[name=taxradio]').change(function(){
    //            console.log($(this).attr('data-name'));
    //        if ($(this).prop('checked') == true) {
    //            var rateText = $(this).attr('data-name');
    //            // $('#taxRate').text(rateText);
    //            $(this).parent().parent().parent().parent().children('a').text(rateText);
    //        }
    //    });
    function removediv(ele){
        $(ele).parent().parent().remove();
    }
    $(document).mouseup(function(e) 
    {
        var container = $(".tax-dropmenu");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
</script>

@stop