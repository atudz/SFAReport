	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>SFA</span> Reports</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{Auth::User()->firstname}} {{Auth::User()->lastname}} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/profile"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
							<li><a href="/changepass"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
							<li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
