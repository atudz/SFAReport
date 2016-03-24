	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" >
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<button type="button" class="navbar-toggle-2 collapsed" >
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<a class="navbar-brand" href="/"><img src="img/sfi_home.jpg" /> <span>SFA SFI</span> Reports - {{getenv('SETUP')}}</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="" class="dropdown-toggle"><span class="glyphicon glyphicon-user"></span> {{Auth::User()->firstname}} {{Auth::User()->lastname}} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#profile.my"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
							<li><a href="#profile.changepassword"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
							<li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
