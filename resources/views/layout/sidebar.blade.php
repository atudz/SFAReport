<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<form role="search">
		<div class="form-group">
			<strong>Main Menu</strong>
            <div hello-world></div>
		</div>
	</form>
	<ul class="nav menu" data-collapse-nav>
	 {{--*/ $counter = 1 /*--}}

	 @if(isset($menu))
            @foreach($menu as $nav)
            {{--*/ $counter++ /*--}}
	            <li @if(count($nav['sub'])) class="parent" href="#sub-item-{{$counter}}" @endif>
	            <a href="@if($nav['url'])#{{$nav['url']}}@endif"><span class="{{$nav['class']}}"></span>             
	            	{{$nav['name']}} 
	            	@if($nav['sub'] && count($nav['sub'])) 
	            		<span class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
	            	@endif
	            </a>
	            
	            @if($nav['sub'] && count($nav['sub']))	            
	            <ul class="children collapse" id="sub-item-{{$counter}}">
	                @foreach($nav['sub'] as $item)
	                	<li>
	                		<a href="#{{$item['url']}}"><span class="{{$item['class']}}"></span>{{$item['name']}}</a>
	                	</li>
	                @endforeach
	            </ul>
	            @endif
	            </li>
        	@endforeach
    @endif
	</ul>
</div><!--/.sidebar-->
