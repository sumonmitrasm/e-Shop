<?php
use App\Section;
$sections = Section::sections();
//echo "<pre>";print_r($getSections);
?>
<div id="sidebar" class="span3">
				<div class="well well-small"><a id="myCart" href="{{url('cart')}}"><img src="{{asset('images/front_images/ico-cart.png')}}" alt="cart"><span class="totalCartItems">{{totalCartItems()}}</span> Items in your cart</a></div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">
					@foreach($sections as $section)
			            @if(count($section['categories'])>0)
					<li class="subMenu"><a>{{$section['name']}}</a>
						<ul>
							@foreach($section['categories'] as $category)
							<li><a href="{{url($category['url'])}}"><i class="icon-chevron-right"></i><strong>{{$category['category_name']}}</strong></a></li>
							@foreach($category['subcategories'] as $subcategory)
							<li><a href="{{url($subcategory['url'])}}"><i class="icon-chevron-right"></i>{{$subcategory['category_name']}}</a></li>
							@endforeach
							@endforeach
						</ul>
					</li>
					 @endif
		            @endforeach
				</ul>
				<br>
				@if(isset($page_name) && $page_name=="listing" && !isset($_REQUEST['search']))
				<div class="well well-small">
					<h4>Fabric</h4>
					@foreach($fabricArray as $fabric)
					<input class="fabric" style="margin-top: -3px;" type="checkbox" name="fabric[]" id="{{$fabric}}" value="{{$fabric}}" placeholder="">&nbsp;&nbsp;{{$fabric}}<br>
					@endforeach
				</div>
				<div class="well well-small">
					<h4>Sleeve</h4>
					@foreach($sleeveArray as $sleeve)
					<input class="sleeve" style="margin-top: -3px;" type="checkbox" name="sleeve[]" id="{{$sleeve}}" value="{{$sleeve}}" placeholder="">&nbsp;&nbsp;{{$sleeve}}<br>
					@endforeach
				</div>
				<div class="well well-small">
					<h4>Pattern</h4>
					@foreach($patternArray as $pattern)
					<input class="pattern" style="margin-top: -3px;" type="checkbox" name="pattern[]" id="{{$pattern}}" value="{{$pattern}}" placeholder="">&nbsp;&nbsp;{{$pattern}}<br>
					@endforeach
				</div>
				<div class="well well-small">
					<h4>Fit</h4>
					@foreach($fitArray as $fit)
					<input class="fit" style="margin-top: -3px;" type="checkbox" name="fit[]" id="{{$fit}}" value="{{$fit}}" placeholder="">&nbsp;&nbsp;{{$fit}}<br>
					@endforeach
				</div>
				<div class="well well-small">
					<h4>Occassion</h4>
					@foreach($occassionArray as $occassion)
					<input class="occassion" style="margin-top: -3px;" type="checkbox" name="occassion[]" id="{{$occassion}}" value="{{$occassion}}" placeholder="">&nbsp;&nbsp;{{$occassion}}<br>
					@endforeach
				</div>
				@endif
				<br/>
				<div class="thumbnail">
					<img src="{{asset('images/front_images/payment_methods.png')}}" title="Payment Methods" alt="Payments Methods">
					<div class="caption">
						<h5>Payment Methods</h5>
					</div>
				</div>
			</div>