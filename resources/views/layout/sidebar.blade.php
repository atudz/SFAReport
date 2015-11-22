<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<strong>Main Menu</strong>
			</div>
		</form>
		<ul class="nav menu">
		 {{--*/ $counter = 1 /*--}}

		 @if(isset($menu))
                @foreach($menu as $nav)
                {{--*/ $counter++ /*--}}
	            <li @if(count($nav['navitems'])) class="parent" @endif>
	            <a href="#{{$nav['url']}}"><span class="{{$nav['class']}}"></span> 
	            	{{$nav['name']}} 
	            	@if(count($nav['navitems'])) 
	            		<span data-toggle="collapse" href="#sub-item-{{$counter}}" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
	            	@endif
	            </a>
	            
	            @if(count($nav['navitems']))
	            <ul class="children collapse" id="sub-item-{{$counter}}">
	                @foreach($nav['navitems'] as $item)
	                	<li>
	                		<a href="#{{$item['url']}}"><span class="{{$item['class']}}"></span>{{$item['name']}}</a>
	                	</li>
	                @endforeach
	            </ul>
	            @endif
	            </li>
	        @endforeach
        @endif
		

			<!-- <li class="active"><a href="index.html"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
			<li><a href="sales.html"><span class="glyphicon glyphicon-list-alt"></span> Sales &amp; Collections</a></li>
			<li><a href="unpaid.html"><span class="glyphicon glyphicon-credit-card"></span> Unpaid Invoice</a></li>
			<li><a href="van.html"><span class="glyphicon glyphicon-barcode"></span> Van Inventory &amp; History</a></li>
			<li><a href="bir.html"><span class="glyphicon glyphicon-th-list"></span> BIR</a></li>
			<li><a href="sync.html"><span class="glyphicon glyphicon-info-sign"></span> Sync Data</a></li>
			<li class="parent ">
				<a href="#">
					<span class="glyphicon glyphicon-list"></span> Sample Dropdown <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 1
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 2
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 3
						</a>
					</li>
				</ul>
			</li> 
			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Login Page</a></li>
 -->

		</ul>
	</div><!--/.sidebar-->