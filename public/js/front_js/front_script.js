$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	//alert("test");
	/*$("#sort").on('change',function(){
		this.form.submit();
	});*/
	$("#sort").on('change',function(){
		//alert("test");
		var sort = $(this).val();
		//alert(sort);
		var url = $("#url").val();
		//alert(url);
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		$.ajax({
			url:url,
			method:"post",
			data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		});
	});

	$(".fabric").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method:"post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});
	});
	$(".sleeve").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method:"post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});
	});
	$(".pattern").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method:"post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});
	});
	$(".fit").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method:"post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});
	});
	$(".occassion").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occassion = get_filter('occassion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method:"post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occassion:occassion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});
	});

	function get_filter(class_name) {
		var filter = [];
		$('.'+class_name+':checked').each(function(){
			filter.push($(this).val());
		});
		return filter;
	}
	//------------------------------------------------------------
	$("#getPrice").change(function(){
		//alert("test");
		var size = $(this).val();
		//alert(size);
		if (size=="") {
			alert("Please select Size");
			return false;
		}
		var product_id = $(this).attr("product-id");
		//alert(product_id);
		$.ajax({
			url:'/get-product-price',
			data:{size:size,product_id:product_id},
			type:'post',
			success:function(resp){
				//alert(resp['product_price']);
				//alert(resp['discounted_price']);
				// return false;
				if (resp['discount']>0) {
					$(".getAttrPrice").html("<del>Rs. "+resp['product_price']+"</del>Rs. "+resp['final_price']); //video91
				}else{
					$(".getAttrPrice").html("Rs."+resp);
				}
				
			},error:function(){
				alert("Error");
			}
		});
	});
	//--------------------------------------------------------
	//update cart items....92---Jq & facebookid
	$(document).on('click','.btnItemUpdate',function(){
		if ($(this).hasClass('qtyMinus')) {
			//if qtyMinus button gets clicked by user
			var quantity = $(this).prev().val();//for total jqury serise see 92 
			//alert(quantity);
			//return false;
			if (quantity<=1) {
				alert("Item quantity must be 1!!");
				return false;
			}else{
				new_qty = parseInt(quantity)-1;
			}
		}
		if ($(this).hasClass('qtyPlus')) {
			//if qtyMinus button gets clicked by user
			var quantity = $(this).prev().prev().val();//for total jqury serise see 92 
			//alert(quantity);
			//return false;
			new_qty = parseInt(quantity)+1;
			
		}
		//alert(new_qty);
		var cartid = $(this).data('cartid');
		//alert(cartid);
		$.ajax({
			data:{"cartid":cartid,"qty":new_qty},
			url:'/update-cart-item-qty',
			type:'post',
			success:function(resp){
				//alert(resp);
				//alert(resp.status);
				if (resp.status==false) {
					alert(resp.message);
				}
				//alert(resp.totalCartItems);
				$(".totalCartItems").html(resp.totalCartItems);
				$("#AppendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});
	//delete cart items..........................................................//95
	$(document).on('click','.btnItemDelete',function(){
		var cartid = $(this).data('cartid');
		//alert(cartid);
		var result = confirm("Confirm delete your product");
		if (result) {
			$.ajax({
			data:{"cartid":cartid},
			url:'/delete-cart-item',
			type:'post',
			success:function(resp){
				$("#AppendCartItems").html(resp.view);
				$(".totalCartItems").html(resp.totalCartItems);
			},error:function(){
				alert("Error");
			}
		});
		}
	});
	//user registration validasion.......................................................99
	$("#registerForm").validate({
			rules: {
				name: "required",
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 11,
					digits: true
				},
				email: {
					required: true,
					email: true,
					remote: "check-email"
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				name: "Please enter your Name",
				mobile: {
					required: "Please enter your mobile Number",
					minlength: "Your mobile number must consist of 11 digits",
					maxlength: "Your mobile number must consist of 11 digits",
					digits: "Please enter your valid mobile number"
				},
				email: {
					required: "Please enter your email",
					email: "Please enter your valid email",
					remote: "Email already exist"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});
	//user kogin validasion.......................................................99
	$("#loginForm").validate({
			rules: {
				email: {
					required: true,
					email: true,
					//remote: "check-email"
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				email: {
					required: "Please enter your email",
					email: "Please enter your valid email",
					//remote: "Email already exist"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});
	//account form validation....................................................108
	$("#accountForm").validate({
			rules: {
				name: {
					required: true,
					lettersonly: true
				},
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 11,
					digits: true
				}
			},
			messages: {
				name: {
					required: "Please enter your Name",
					lettersonly: "Please enter valid Name"
				},
				mobile: {
					required: "Please enter your mobile Number",
					minlength: "Your mobile number must consist of 11 digits",
					maxlength: "Your mobile number must consist of 11 digits",
					digits: "Please enter your valid mobile number"
				}
			}
		});
	//fornt current password show message.........................................110
	$("#current_pwd").keyup(function(){
		var current_pwd = $(this).val();
		//alert(current_pwd);
		$.ajax({
			type:'post',
			url:'/check-user-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				//alert(resp);
				if (resp=="false") {
					$("#chkPwd").html("<font color=red>Current password is incorrect</font>");
				}else if (resp=="true") {
					$("#chkPwd").html("<font color=green>Current password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});
	//account login form validation...............................................110
	$("#passwordForm").validate({
			rules: {
				current_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20
				},
				new_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20
				},
				confirm_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20,
					equalTo:"#new_pwd"
				}
			}
		});
	// cupon code from ............................................................119
	$("#ApplyCoupon").submit(function(){
		//alert("test");
		var user = $(this).attr("user");
		if (user==1) {
			//do nothing
		}else{
			alert("Please login to apply Coupon");
			return false;
		}
		var code = $("#code").val();
		//alert(code);
		$.ajax({
			type:'post',
			data:{code:code},
			url:'/apply-coupon',
			success:function(resp){
				if (resp.messages!="") {
					alert(resp.messages);
				}
				$(".totalCartItems").html(resp.totalCartItems);
				$("#AppendCartItems").html(resp.view);
				if (resp.couponAmount>=0) {
					$(".couponAmount").text("Rs."+resp.couponAmount);
				}else{
					$(".couponAmount").text("Rs.0");
				}
				if (resp.grand_total>=0) {
					$(".grand_total").text("Rs."+resp.grand_total);
				}
			},error:function(){
				alert("Error");
			}
		})
	});
	//delete dalivary
	$("#addressDelete").click(function() {
		var result = confirm("Are you sure to delete this");
		if (!result) {
			return false;
		}
		
	});

	$("input[name=address_id]").bind('change',function() {
		var shipping_charges = $(this).attr("shipping_charges");
		var total_price = $(this).attr("total_price");
		var coupan_ammount = $(this).attr("coupan_ammount");
		var codpincodeCount = $(this).attr("codpincodeCount");
		var prepaidpincodeCount = $(this).attr("prepaidpincodeCount");
		
		if (codpincodeCount>0) {
			$(".codMethod").show();
		}else{
			$(".codMethod").hide();
		}
		if (prepaidpincodeCount>0) {
			$(".prepaidMethod").show();
		}else{
			$(".prepaidMethod").hide();
		}


		if (coupan_ammount=="") {
			coupan_ammount = 0;
		}
		//alert(codpincodeCount); //............156
		$(".shipping_charges").html("Rs."+shipping_charges);
		var grand_total = parseInt(total_price) + parseInt(shipping_charges) - parseInt(coupan_ammount);
		//alert(grand_total);
		$(".grand_total").html("Rs."+grand_total);

	});
	
	$("#checkPincode").click(function () {
		var pincode = $("#pincode").val();
		//alert(pincode);//......................167
		if (pincode =="") {
			alert("Please enter pincode"); return false;
		}
		$.ajax({
			type:'post',
			data:{pincode:pincode},
			url:'/check-pincode',
			success:function(resp){
				alert(resp);
			},error:function(){
				alert("Error");
			}
		});
	});
});