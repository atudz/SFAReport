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
            <li @if(count($nav['navitems'])) class="parent" @endif>
            <a href="@if($nav['url'])#{{$nav['url']}}@endif"><span class="{{$nav['class']}}"></span>             
            	{{$nav['name']}} 
            	@if(count($nav['navitems'])) 
            		<span href="#sub-item-{{$counter}}" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
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
	</ul>
</div><!--/.sidebar-->