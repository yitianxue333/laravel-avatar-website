// $(document).ready(function (argument) {
// 	$('.add-week-form').click(function(){
		
// 		 var data = {!! $json !!};
// 		console.log(params);
// 		var str_part;
// 		var week_category_select= '<li class="row week-category-select">                  <div class="col-lg-9">                    <select class="form-control control-category selectpicker" id="control-category" name="category">                        <optgroup label="General">                          <option value="111">General</option>                        </optgroup>                        <optgroup label="Clients">';  
// 			for (var i=0;i<params.length;i++)
// 			{

// 				str_part1 = '<option  dir="rtl" value="'+params[i]['job_id']+'">'+{!! $item->first_name !!}+' '+{!! $item->last_name !!}+'</option>';
// 				str_part = str_part + str_part1;
// 			}
// 			week_category_select = week_category_select + str_part+' </optgroup>                 </select>                  </div>                  <div class="col-lg-3">                    <a href="#" class="cancel-entries-btn list-btn btn" onClick="week_entries_cancel(this)">cancel</a>                    <a href="#" class="add-entries-btn list-btn btn custom-btn-color" onClick="week_entries_add(this)">Add Entries</a>                  </div>                </li>';

		                           
// 		        		$('.week-form-list').append(week_category_select);
		
// 	});


	

// });
// function week_entries_cancel(obj){
// 		$('.week-form-list .week-category-select').has(obj).remove();
// 	}
// 	function week_entries_add(obj){
// 		var selecter = $('.week-category-select').has(obj);
// 		var week_form = '<li class="row week-category-list"> <div class="col-lg-2 week-time-manner">                    <h3>General</h3>                  </div>                 <div class="col-lg-10">                    <div class="col-week">                    <input  type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                                        </div>                    <div class="col-week">                      <input type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control "  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control"  placeholder="0:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                  </div>                </li>';
// 		selecter.replaceWith(week_form);
// 	}