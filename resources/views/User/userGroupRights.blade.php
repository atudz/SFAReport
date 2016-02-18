{!!Html::breadcrumb(['User Management','User Group Rights'])!!}
{!!Html::pageheader('User Group Rights')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				{!!Html::topen(['no_search'=>true,'no_download'=>true])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<!-- Record list -->
						<tr ng-repeat="record in records|filter:query" id="[[record.id]]">
							<td>[[record.id]]</td>
							<td>[[record.name]]</td>
						</tr>						
					</tbody>
					{!!Html::tfooter(true,2)!!}					
				{!!Html::tclose()!!}
			</div>			
		</div>
	</div>
</div>
