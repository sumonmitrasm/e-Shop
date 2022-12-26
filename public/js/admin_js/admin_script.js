$(document).ready(function() {
	$("#current_pwd").keyup(function() {
		var current_pwd = $("#current_pwd").val();
		//alert(current_pwd);
		$.ajax({
			type:'post',
			url:'/admin/check-current-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp) {
				//alert(resp);
				if (resp=="false") {
					$("#chkCurrentPwd").html("<font color=red>Current password is incorrect</font>");
				}else if (resp=="true") {
					$("#chkCurrentPwd").html("<font color=green>Current password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}

		});
	});
	//});
	$(".updateSectionStatus").click(function() {
		//$(document).on("click",".updateSectionStatus",function(){
		var status = $(this).text();
		var section_id =$(this).attr("section_id");
		//alert(status);
		//alert(section_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-section-status',
			data:{status:status,section_id:section_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['section_id']);
				if (resp['status']==0) {
					$("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Inactive</a>");
				}else{
					if (resp['status']==1) {
						$("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Active</a>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//Category
	$(".updateCategoryStatus").click(function() {
		//$(document).on("click",".updateCategoryStatus",function(){
		var status = $(this).text();
		var category_id =$(this).attr("category_id");
		//alert(status);
		//alert(category_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-category-status',
			data:{status:status,category_id:category_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['category_id']);
				if (resp['status']==0) {
					$("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>");
				}else{
					if (resp['status']==1) {
						$("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//Append Category level
	$('#section_id').change(function() {
		var section_id = $(this).val();
		//alert(section_id);
		$.ajax({
			type:'post',
			url:'/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategoriesLevel").html(resp);
			},error:function(){
				alert("Error");
			}

		});
		
	});

	//confirm deletion of record
	/*$(".confirmDelete").click(function() {
		var name = $(this).attr("name");
		if (confirm("Are you sure to delete this "+name+"?")) {
			return true;
		}
		return false;
	});*/
	//confirm deletion of record
	//$(".confirmDelete").click(function() {
		$(document).on("click",".confirmDelete",function(){
		var record = $(this).attr("record");
		var recordid = $(this).attr("recordid");
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		    window.location.href="/admin/delete-"+record+"/"+recordid;
		  }
		});	
	});
	
	//product status.........................................................................
	//$(".updateProductStatus").click(function() {
		$(document).on("click",".updateProductStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var product_id =$(this).attr("product_id");
		//alert(status);
		//alert(product_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-product-status',
			data:{status:status,product_id:product_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['product_id']);
				if (resp['status']==0) {
					$("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//Update ProuctAttribute Status.......................................................
	//$(".updateAttributStatus").click(function() {
		$(document).on("click",".updateAttributStatus",function(){
		var status = $(this).children("i").attr("status");
		var attribute_id =$(this).attr("attribute_id");
		//alert(status);
		//alert(attribute_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-attribute-status',
			data:{status:status,attribute_id:attribute_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['attribute_id']);
				if (resp['status']==0) {
					$("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});

	//Delete ProductAttribute.........................
	//$(".confirmDelete").click(function() {
		$(document).on("click",".confirmDelete",function(){
		var record = $(this).attr("record");
		var recordid = $(this).attr("recordid");
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		    window.location.href="/admin/delete-"+record+"/"+recordid;
		  }
		});	
	});

	//Delete Product.........................
	//$(".confirmDelete").click(function() {
		$(document).on("click",".confirmDelete",function(){
		var record = $(this).attr("record");
		var recordid = $(this).attr("recordid");
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		    window.location.href="/admin/delete-"+record+"/"+recordid;
		  }
		});	
	});
	//Product attibut of add remove script................................................................
	var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height: 5px;"></div><input type="text" name="size[]" style="width: 110px;" placeholder="Size"/>&nbsp;<input type="text" name="price[]" style="width: 110px;" placeholder="Price"/>&nbsp;<input type="text" name="stock[]" style="width: 110px;" placeholder="Stock"/>&nbsp;<input type="text" name="sku[]" style="width: 110px;" placeholder="SKU"/><a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    //Addissional Images Status updated..........................................
    //$(".updateImageStatus").click(function() {
    	$(document).on("click",".updateImageStatus",function(){
		var status = $(this).children("i").attr("status");
		var image_id =$(this).attr("image_id");
		//alert(status);
		//alert(image_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-image-status',
			data:{status:status,image_id:image_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['image_id']);
				if (resp['status']==0) {
					$("#image-"+image_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#image-"+image_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//Brand status.........................................................................
	//$(".updateBrandStatus").click(function() {
		$(document).on("click",".updateBrandStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var brand_id =$(this).attr("brand_id");
		//alert(status);
		//alert(brand_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-brand-status',
			data:{status:status,brand_id:brand_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['brand_id']);
				if (resp['status']==0) {
					$("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});

	//Coupon status.........................................................................
		$(document).on("click",".updateCouponsStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var coupon_id =$(this).attr("coupon_id");
		//alert(status);
		//alert(coupon_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-coupons-status',
			data:{status:status,coupon_id:coupon_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['coupon_id']);
				if (resp['status']==0) {
					$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
		//bannars.................................................................
	//$(".updateBannerStatus").click(function() {
		$(document).on("click",".updateBannerStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var banner_id =$(this).attr("banner_id");
		//alert(status);
		//alert(banner_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-banners-status',
			data:{status:status,banner_id:banner_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['banner_id']);
				if (resp['status']==0) {
					$("#banner-"+banner_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#banner-"+banner_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//coupon  selector.............................................................115
	$("#ManualCoupon").click(function(){
		$("#couponFild").show();
	});
	$("#AutomaticCoupon").click(function(){
		$("#couponFild").hide();
	});
	//courier_name & tracking_number....from order_details.blade.php................116
	$("#courier_name").hide();
	$("#tracking_number").hide();
	$("#order_status").on("change",function(){
		//alert(this.value);die;
		if (this.value=="Shipped") {
			$("#courier_name").show();
			$("#tracking_number").show();
		}else{
			$("#courier_name").hide();
			$("#tracking_number").hide();	
		}
	});

	//shipping_charges.................................................................153
	//$(".updateShippingStatus").click(function() {
		$(document).on("click",".updateShippingStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var shipping_id =$(this).attr("shipping_id");
		//alert(status);
		//alert(shipping_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-shipping-status',
			data:{status:status,shipping_id:shipping_id},
			success:function(resp){
				//alert(resp['status']);die;
				//alert(resp['shipping_id']);
				if (resp['status']==0) {
					$("#shipping-"+shipping_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#shipping-"+shipping_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
	//update users status....................................................170
	//$(".updateBrandStatus").click(function() {
		$(document).on("click",".updateUserStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var users_id =$(this).attr("users_id");
		//alert(status);
		//alert(users_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-user-status',
			data:{status:status,users_id:users_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['users_id']);
				if (resp['status']==0) {
					$("#users-"+users_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#users-"+users_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});

	//update cms pages status....................................................175
	//$(".updateBrandStatus").click(function() {
		$(document).on("click",".updateSmsPageStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var cms_id =$(this).attr("cms_id");
		//alert(status);
		//alert(cms_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-smspage-status',
			data:{status:status,cms_id:cms_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['cms_id']);
				if (resp['status']==0) {
					$("#cms-"+cms_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#cms-"+cms_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});

	//update Admin/superadmin status....................................................180
	//$(".updateBrandStatus").click(function() {
		$(document).on("click",".updateAdminStatus",function(){
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var admin_id =$(this).attr("admin_id");
		//alert(status);
		//alert(admin_id); die;
		$.ajax({
			type:'post',
			url:'/admin/update-admin-status',
			data:{status:status,admin_id:admin_id},
			success:function(resp){
				//alert(resp['status']);
				//alert(resp['admin_id']);
				if (resp['status']==0) {
					$("#admin-"+admin_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else{
					if (resp['status']==1) {
						$("#admin-"+admin_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
					}
				}

			},error:function(){
				alert("Error");

			}
		});
	});
}); 