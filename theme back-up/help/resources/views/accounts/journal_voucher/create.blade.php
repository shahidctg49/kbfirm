@extends('layout.app')
@section('title','Journal Voucher Add')
@push('style')
<style>
select {
    padding: 3px 4px;
    height: 34px;
}
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
	@if(Session::has('response'))
        <div class="alert alert-{{Session::get('response')['class']}}">
        {{Session::get('response')['message']}}
        </div>
    @endif
        <!-- PAGE CONTENT BEGINS -->
        <div class="widget-box">
			<div class="widget-body">
				<div class="widget-main">
				<form action="{{route(currentUser().'.journal.store')}}" onsubmit="return chech_sum()" method="post" class="form-search">
					@csrf
						<div class="row">
							<div class="col-12 col-sm-3">
								<div class="form-group ">
									<label>Journal No</label>
									<span class="block input-icon input-icon-right">
										<input type="text" class="width-100" name="voucher_no" value="" readonly>
									</span>
								</div>
							</div>	
							<div class="col-12 col-sm-3">
								<div class="form-group @if($errors->has('v_date')) has-error @endif">
									<label>Date</label>
									<span class="block input-icon input-icon-right">
										<input type="date" class="width-100" name="v_date" value="{{date('Y-m-d')}}">
										@if($errors->has('v_date')) 
											<i class="ace-icon fa fa-times-circle"></i>
										@endif
									</span>
									@if($errors->has('v_date')) 
										<div class="help-block col-sm-reset">
									{{ $errors->first('v_date') }}
										</div>
								@endif
								</div>
							</div>	
							<div class="col-12 col-sm-6">
								<div class="form-group @if($errors->has('particular')) has-error @endif">
									<label>Particulars</label>
									<span class="block input-icon input-icon-right">
										<input type="text" class="width-100" name="particular" value="{{old('name')}}">
										@if($errors->has('particular')) 
											<i class="ace-icon fa fa-times-circle"></i>
										@endif
									</span>
									@if($errors->has('particular')) 
										<div class="help-block col-sm-reset">
									{{ $errors->first('particular') }}
										</div>
								@endif
								</div>
							</div>	
						</div>
						<div class="row">
							<div class="col-12">
							    <table class="table table-bordered" id='account'>
									<thead>
										<tr>
											<th>SN#</th>
											<th>A/C Head</th>
											<th>Debit (Tk)</th>
											<th>Credit (Tk)</th>
											<th>Remarks</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th style="text-align:right;" colspan="2">Total Amount Tk.</th>
											<th><input type='text' name='debit_sum' id='debit_sum' value='' style='text-align:center; border:none;' readonly autocomplete="off" /></th>
											<th><input type='text' name='credit_sum' id='credit_sum' value='' style='text-align:center; border:none;' readonly autocomplete="off" /></th>
											<th></th>
										</tr>
										<tr>
											<th style="text-align:right;" colspan="5">
												<input type='button' class='btn btn-primary' value='Add' onClick='add_row();'>
												<input type='button' class='btn btn-danger' value='Remove' onClick='remove_row();'>
											</th>
										</tr>
									</tfoot>
									<tbody style="background:#eee;">
										<tr>
											<td style='text-align:center;'>1</td>
											<td style='text-align:left;'>
												<div style='width:100%;position:relative;'>
													<input type='text' name='account_code[]' class='cls_account_code form-control' value='' style='border:none;' onkeyup="get_head(this);" maxlength='100' autocomplete="off"/>
													<div class="sugg" style='display:none;'>
														<div style='border:1px solid #aaa;'></div>
													</div>
												</div>
													<input type='hidden' class='table_name' name='table_name[]' value=''>
													<input type='hidden' class='table_id' name='table_id[]' value=''>
											</td>
											<td style='text-align:left;'>
												<input type='text' name='debit[]' class='cls_debit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return debit_entry(this);' autocomplete="off"/> 
											</td>
											<td style='text-align:left;'>
												<input type='text' name='credit[]' class='cls_credit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return credit_entry(this);' autocomplete="off" /> 
												<input type='hidden' name='jobinc[]' class='jobinc' value='1'>
												<input type='hidden' name='bkdn_id[]' value='' />
											</td>
											<td style='text-align:left;'><input type='text' class=" form-control" name='remarks[]' value='' maxlength='50' style='text-align:left;border:none;' /></td>
										</tr>
										<tr>
											<td style='text-align:center;'>2</td>
											<td style='text-align:left;'>
												<div style='width:100%;position:relative;'>
													<input type='text' name='account_code[]' class='cls_account_code form-control' value='' style='border:none;' onkeyup="get_head(this)" maxlength='100' autocomplete="off"/>
													<div class="sugg" style='display:none;'>
														<div style='border:1px solid #aaa;'></div>
													</div>
												</div>
													<input type='hidden' class='table_name' name='table_name[]' value=''>
													<input type='hidden' class='table_id' name='table_id[]' value=''>
											</td>
											<td style='text-align:left;'>
												<input type='text' name='debit[]' class='cls_debit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return debit_entry(this);' autocomplete="off"/> 
											</td>
											<td style='text-align:left;'>
												<input type='text' name='credit[]' class='cls_credit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return credit_entry(this);' autocomplete="off" /> 
												<input type='hidden' name='jobinc[]' class='jobinc' value='2'>
												<input type='hidden' name='bkdn_id[]' value='' />
											</td>
											<td style='text-align:left;'><input type='text' name='remarks[]' class=' form-control' value='' maxlength='50' style='text-align:left;border:none;' /></td>
										</tr>
									</tbody>
								</table>
							</div>	
						</div>
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="form-group @if($errors->has('name')) has-error @endif">
									<label>Cheque No</label>
									<span class="block input-icon input-icon-right">
										<input type="text" class="width-100" name="cheque_no" value="{{old('cheque_no')}}">
										@if($errors->has('cheque_no')) 
											<i class="ace-icon fa fa-times-circle"></i>
										@endif
									</span>
									@if($errors->has('cheque_no')) 
										<div class="help-block col-sm-reset">
											{{ $errors->first('cheque_no') }}
										</div>
									@endif
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group @if($errors->has('bank_name')) has-error @endif">
									<label>Bank Name</label>
									<span class="block input-icon input-icon-right">
										<input type="text" class="width-100" name="bank_name" value="{{old('bank_name')}}">
										@if($errors->has('bank_name')) 
											<i class="ace-icon fa fa-times-circle"></i>
										@endif
									</span>
									@if($errors->has('bank_name')) 
										<div class="help-block col-sm-reset">
											{{ $errors->first('bank_name') }}
										</div>
									@endif
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group @if($errors->has('cheque_date')) has-error @endif">
									<label>Cheque Date</label>
									<span class="block input-icon input-icon-right">
									<input type="text" class="width-100" name="cheque_date" >
											<i class="ace-icon fa fa-times-circle"></i>
									</span>
									@if($errors->has('cheque_date')) 
										<div class="help-block col-sm-reset">
											{{ $errors->first('cheque_date') }}
										</div>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 text-right">
								<input name="Upload File" type="file" name="slip[]" multiple>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 text-right">
								<button class="btn btn-primary" type="submit"> Save Changes </button>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
    </div>
</div>
@endsection

@push('script')
<script>
    function chech_sum(){
        if($("#debit_sum").val() == $("#credit_sum").val()){
            return true;
        }else{
            alert("Both debit and credit amount are not same");
            return false;
        }
    }
	function add_row(){

		var row="<tr>\
					<td style='text-align:center;'>"+(parseInt($("#account tbody tr").length) + 1)+"</td>\
					<td style='text-align:left;'>\
						<div style='width:100%;position:relative;'>\
							<input type='text' name='account_code[]' class='cls_account_code form-control' value='' style='border:none;' onkeyup='get_head(this)' maxlength='100' autocomplete='off'/>\
							<div class='sugg' style='display:none;'>\
								<div style='border:1px solid #aaa;'></div>\
							</div>\
						</div>\
							<input type='hidden' class='table_name' name='table_name[]' value=''>\
							<input type='hidden' class='table_id' name='table_id[]' value=''>\
					</td>\
					<td style='text-align:left;'>\
						<input type='text' name='debit[]' class='cls_debit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return debit_entry(this);' autocomplete='off'/> \
					</td>\
					<td style='text-align:left;'>\
						<input type='text' name='credit[]' class='cls_credit form-control' value='' style='text-align:center; border:none;' maxlength='15' onkeyup='removeChar(this)' onBlur='return credit_entry(this);' autocomplete='off' /> \
						<input type='hidden' name='jobinc[]' class='jobinc' value='2'>\
						<input type='hidden' name='bkdn_id[]' value='' />\
					</td>\
					<td style='text-align:left;'><input type='text' name='remarks[]' value='' class=' form-control' maxlength='50' style='text-align:left;border:none;' /></td>\
				</tr>";
		$('#account tbody').append(row);
	}

	function remove_row(){
		$('#account tbody tr').last().remove();
	}
	
	/*function get_head(e){
    	$.ajax({
            type: "GET",
            url: "{{route('superadmin.get_head')}}",
            data: {'code':$(e).val()},
    		dataType: "json",
            success: function(msg) {
                
    			autocomplete($(e).next('div'), msg);
            }
        });
    }*/
    function get_head(code){
	    if($(code).val()!=""){
            $.getJSON( "{{route(currentUser().'.get_head')}}",{'code':$(code).val()}, function(j){
	            if(j.length>0){
            		var data			= '';
            		var table_name 		= '';
            		var table_id 		= '';
            		var display_value 	= '';
		
            		for (var i = 0; i < j.length; i++) {
            			var table_name 		= j[i].table_name;
            			var table_id 		= j[i].table_id;
            			var display_value 	= j[i].display_value;
            			data += '<div style="cursor: pointer;padding:5px 10px;border-bottom:1px solid #aaa" class="item" align="left" onClick="account_code_fill(\''+display_value+'\',this,\''+table_name+'\','+table_id+');"><b>'+display_value+'</b></div>';
		
            		}
		
            		$(code).next().find('div').html(data);
            		$(code).next().find('div').css('background-color', '#FFFFE0');
            		$(code).next().fadeIn("slow");
	            }else{
            		$(code).parents('td').find('.table_name').val('');
            		$(code).parents('td').find('.table_id').val('');
            		$(code).val('');
            		$(code).css('background-color', '#D9A38A');
            		$(code).next().fadeOut();
            	}
            });		
        }else {
            $(code).parents('td').find('.table_name').val('');
            $(code).parents('td').find('.table_id').val('');
            $(code).val('');
            $(code).css('background-color', '#D9A38A');
            $(code).next().fadeOut();
        }
    }
    
    function account_code_fill(value,code,tablename,tableid) {
    	$(code).parents('td').find('.cls_account_code').css('background-color', '#FFFFE0');
    	$(code).parents('td').find('.cls_account_code').val(value);
    	$(code).parents('td').find('.table_name').val(tablename);
    	$(code).parents('td').find('.table_id').val(tableid);
    
    	$(code).parents('td').find('.sugg').fadeOut();
    	$(code).parents('td').find('.cls_account_code').focus();
    }
    function removeChar(item){ 
    	var val = item.value;
      	val = val.replace(/[^.0-9]/g, "");  
      	if (val == ' '){val = ''};   
      	item.value=val;
    }
    function sum_of_debit_credit(){
    	$.total_debit=0;
    	$.total_credit=0;
    	
    	/* Debit SUM */
    	$(".cls_debit").each(function(){
    		var debit_amount=$(this).val();
    		$.total_debit+=Number(debit_amount);
    	});
    	/* Debit SUM */
    	
    	/* Credit SUM */
    	$(".cls_credit").each(function(){
    		var credit_amount=$(this).val();
    		$.total_credit+=Number(credit_amount);
    	});
    	/* Credit SUM */
    	
    	$("#debit_sum").val($.total_debit);
    	$("#credit_sum").val($.total_credit);	
    }
    
    function debit_entry(inc){
    	if($(inc).parents('tr').find('.cls_account_code').val()!=''){
    		var debit_amount = Number($(inc).val());
			$(inc).parents('tr').find('.cls_credit').val('');
			sum_of_debit_credit();
    	}else {
    		alert("Please Enter Account Code");
    		$(inc).val('');
    		sum_of_debit_credit();
    		$(inc).parents('tr').find('.cls_account_code').focus();
    	}
    }
    
    function credit_entry(inc){
    	if($(inc).parents('tr').find('.cls_account_code').val()!=''){
    		var credit_amount = Number($(inc).val());
			$(inc).parents('tr').find('.cls_debit').val('');
			sum_of_debit_credit();
    		
    	}
    	else {
    		alert("Please Enter Account Code");
    		$(inc).val('');
    		sum_of_debit_credit();
    		$(inc).parents('tr').find('.cls_account_code').focus();
    	}
    }

</script>

@endpush