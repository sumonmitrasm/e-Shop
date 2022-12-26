<?php use App\Product;?>
<?php use App\Category;?>
<div class="tab-pane  active" id="blockView">
	<ul class="thumbnails">
		@foreach($categoryProducts as $product)
		<li class="span3">
			<div class="thumbnail" style="height: 420px;">
					@if(isset($product['main_image']))
				<a  href="{{url('product/'.$product['id'])}}"><?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
				@else
				<?php $product_image_path = '';?>
				@endif
				@if(!empty($product['main_image']) && file_exists($product_image_path))
					<img width="150px;" src="{{asset($product_image_path)}}" alt="">
				@else
					<img width="150px;" src="{{asset('images/product_images/small/no_image.PNG')}}" alt="">
				@endif</a>
				<div class="caption">
					<h5>{{$product['product_name']}}</h5>
					<p>
						{{$product['brand']['name']}}
					</p>
					
					<?php $discounted_price = Product::getDiscountedPrice($product['id']);?>
					
					<h4 style="text-align:center"><a class="btn" href="{{url('product/'.$product['id'])}}"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="{{url('product/'.$product['id'])}}">
						@if($discounted_price>0)
							<del>Rs.{{$product['product_price']}}</del>
						@else
							Rs.{{$product['product_price']}}
						@endif
						</a></h4>
						@if($discounted_price>0)
						<h4 style="text-align:center"> <a class="btn btn-primary" href="{{url('product/'.$product['id'])}}">Discounted Price: {{$discounted_price}}</a>
						@endif
					<p>
						{{$product['fabric']}}
					</p>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	<hr class="soft"/>
</div>