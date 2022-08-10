<div class="jumbotron <?php if ($classroom->headerImage): ?>jumbotron-image<?php endif; ?>" <?php if ($classroom->headerImage): ?>style="background-image: url('<?php echo url(Config::get('ringmaster.uploads_url_path')."/".$classroom->headerImage->filename);?>')"<?php endif;?>>
	<div class="container">
		<div class="col-xs-12">
			<h1>
				<?php echo $class->name;?>
			</h1>
			<h3 class="text-muted">
				<?php if($class->code): ?><?php echo $class->code;?>, <?php endif; ?> 
				<?php if(count($class->creators)) echo $class->creators[0]->prettyName();?>
			</h3>
		</div>
		<?php if ($classroom->is_admin()): ?>
		<div class="join-box text-right">
			<a href="javascript:;" id="showJoinCodeButton">show join code</a>
			<h5 class="text-muted" style="display: none;" ><!-- data-intro='Join codes!' -->
				Join Code:
			</h5>
			<h2 id="joinCode" style="display: none;">
				<?php if ($class->join_code): ?>
					<?php echo $class->join_code;?>
				<?php else: ?>
					[generating]
				<?php endif; ?>
			</h2>
			<a href="javascript:;" style="display: none;" id="hideJoinCodeButton">hide join code</a>
			<span style="display: none;"> | </span> 
			<a id="newJoinCode" style="display: none;" href="<?php echo action('ClassroomController@generate_code', $class->id);?>">new code</a>
		</div>
		<?php endif; ?>	
	</div>
</div>

<div class="container">

	<div class="col-xs-12">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li <?php if (!Request::input("show") || Request::input("show") == "info"):?>class="active"<?php endif; ?>>
				<a href="#info" role="tab" data-toggle="tab">Class Info</a>
			</li>
			<?php if ($classroom->is_user()): ?>
			<li <?php if (Request::input("show") == "files"):?>class="active"<?php endif; ?>>
				<a href="#files" role="tab" data-toggle="tab">Class Files</a>
			</li>
			<li <?php if (Request::input("show") == "assignments"):?>class="active"<?php endif; ?>>
				<a href="#assignments" role="tab" data-toggle="tab">Assignments <span class="badge"><?php echo count($classroom->futureAssignments);?></span></a>
			</li>
			<li <?php if (Request::input("show") == "grades"):?>class="active"<?php endif; ?>>
				<a href="#grades" role="tab" data-toggle="tab">Grades</a>
			</li>
			<li <?php if (Request::input("show") == "events"):?>class="active"<?php endif; ?>>
				<a href="#events" role="tab" data-toggle="tab">Events <span class="badge"><?php echo count($classroom->futureEvents);?></span></a>
			</li>
			<li <?php if (Request::input("show") == "discussion"):?>class="active"<?php endif; ?>>
				<a href="#discussion" role="tab" data-toggle="tab">Discussion <span class="badge"><?php echo count($classroom->posts);?></span></a>
			</li>
			<li <?php if (Request::input("show") == "people"):?>class="active"<?php endif; ?>>
				<a href="#people" role="tab" data-toggle="tab">People</a>
			</li>
			<?php endif; ?>
			<?php if ($classroom->is_admin()): ?>
			<li <?php if (Request::input("show") == "settings"):?>class="active"<?php endif; ?>>
				<a href="#settings" role="tab" data-toggle="tab">Settings</a>
			</li>
			<?php endif; ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div id="info" class="tab-pane fade <?php if (!Request::input("show") || Request::input("show") == "info"):?>in active<?php endif; ?>">

				<div class="col-xs-12">

					<!--
					is creator: <?php echo $classroom->is_creator();?><br />
					is admin: <?php echo $classroom->is_admin();?><br />
					is user: <?php echo $classroom->is_user();?><br />
					is member: <?php echo $classroom->is_member();?><br />
					is banned: <?php echo $classroom->is_banned();?><br />
					-->

					<?php if ($classroom->description): ?>
						<h2>Description</h2>
						<p>
							<?php echo $classroom->description; ?>
						</p>
						<br /><br />
					<?php endif; ?>
					<h2>Membership</h2>
					<p>
						<?php if ($classroom->is_creator()): ?>
							You are the creator of this class.
						<?php elseif ($classroom->is_admin()): ?>
							You are an admin for this class.
						<?php elseif ($classroom->is_user()): ?>
							You are in this class.
							<a class="btn btn-sm btn-default" href="<?php echo action('ClassroomController@leave', $classroom->id);?>"><span class="glyphicon glyphicon-remove"></span> Leave Class</a>
						<?php elseif ($classroom->is_banned()): ?>
							You have been kicked out of this class.
						<?php else: ?>
							You are not in this class.
						<?php endif; ?>

						<?php if ($classroom->is_creator() || $classroom->is_admin()): ?>
							<a class="ajax-modal" href="<?php echo action('ClassroomController@edit', $classroom->id);?>">Edit Class?</a>
						<?php endif; ?>
					</p>


					
				</div>
				
			</div>




		<?php if ($classroom->is_user()): ?>
			

			<div id="assignments" class="tab-pane fade <?php if (Request::input("show") == "assignments"):?>in active<?php endif; ?>">
				<h2>
					Assignments
					<?php if ($classroom->is_admin()): ?>
						<a href="<?php echo action('AssignmentController@create', array($classroom->id));?>" class="btn btn-default btn-sm ajax-modal" style="float: right">
							<span class="glyphicon glyphicon-plus text-muted"></span> Create Assignment
						</a>
					<?php endif; ?>	
				</h2>
				<?php echo View::make('assignment._list', array("assignments" => $classroom->assignments)); ?>
			</div>
			



			<div id="grades" class="tab-pane fade <?php if (Request::input("show") == "grades"):?>in active<?php endif; ?>">
				
				<h2>Grades</h2>

				<?php if ($classroom->is_admin()): ?>
					<?php echo View::make('class._gradesAdmin', array("classroom" => $classroom)); ?>
				<?php elseif ($classroom->is_user()): ?>
					<?php echo View::make('class._grades', array("classroom" => $classroom)); ?>
				<?php endif;?>
			</div>





			<div class="tab-pane fade <?php if (Request::input("show") == "discussion"):?>in active<?php endif; ?>" id="discussion">
				<h2>
					Discussion
					<a href="<?php echo action('PostController@create', array("classroom", $classroom->id));?>" class="btn btn-default btn-sm ajax-modal" style="float: right">
						<span class="glyphicon glyphicon-plus text-muted"></span> Post Something
					</a>
				</h2>

				<?php //=View::make('post._create', array("type" => "classroom", "id" => $classroom->id)); ?>
				<br>
				<?php echo View::make('post._list', array("posts" => $classroom->posts)); ?>
			</div>
			




			<div class="tab-pane fade <?php if (Request::input("show") == "events"):?>in active<?php endif; ?>" id="events">
				<h2>
					Events
					<?php if ($classroom->is_admin()): ?>
						<a href="<?php echo action('CalendarEventController@create', ["classroom", $classroom->id]);?>" class="btn btn-default btn-sm ajax-modal" style="float: right">
							<span class="glyphicon glyphicon-plus text-muted"></span> Create Event
						</a>
					<?php endif; ?>	
				</h2>
				<?php echo View::make('event._list', array("events" => $classroom->events)); ?>
			</div>



			<div class="tab-pane fade <?php if (Request::input("show") == "people"):?>in active<?php endif; ?>" id="people">
				<h2>People</h2>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>	
							<th>Role</th>
							<?php if ($classroom->is_admin()): ?>
								<th>Change Role</th>
							<?php endif; ?>
						</tr>
						<?php 
						$userList = $classroom->users;
						if ($classroom->is_admin()) $userList = $classroom->allUsers;
						foreach ($userList as $u): ?>
							<tr>
								<td><?php echo $u->prettyName(); ?></td>
								<td><?php echo $u->email; ?></td>	
								<td>
									<?php if ($u->id == 1): ?>
										god
									<?php else: ?>
										<?php echo $u->pivot->role?$u->pivot->role:"ex-member" ?>
									<?php endif; ?>
								</td>
								
								<?php if ($classroom->is_admin()): // the logged in user is an admin ?>									
									<td>
										<?php if ($u->id == 1):?>
											lol
										<?php elseif ($u->pivot->role == "creator"):?>

										<?php elseif ($u->pivot->role != "banned"):?>
											<?php if ($u->pivot->role):?>
												<?php if ($u->pivot->role != "creator" && $u->pivot->role != "admin"):?>
													<a class="ajax-simple btn btn-default" href="<?php echo action("ClassroomController@role", [$classroom->id, $u->id, "admin"]);?>">
														Promote to Administrator/Teacher
													</a>
												<?php endif; ?>
												<?php if ($u->pivot->role == "admin"):?>
													<a class="ajax-simple btn btn-default" href="<?php echo action("ClassroomController@role", [$classroom->id, $u->id, "member"]);?>">
														Demote to Member/Student
													</a>
												<?php endif; ?>
												<a class="ajax-simple btn btn-default" href="<?php echo action("ClassroomController@role", [$classroom->id, $u->id, "none"]);?>">
													Drop
												</a>
											<?php endif; ?>
											<a class="ajax-simple btn btn-default" href="<?php echo action("ClassroomController@role", [$classroom->id, $u->id, "banned"]);?>">
												<?php if ($u->pivot->role):?>Drop and <?php endif; ?>Ban
											</a>
										<?php elseif ($u->pivot->role == "banned"):?>
											<a class="ajax-simple btn btn-default" href="<?php echo action("ClassroomController@role", [$classroom->id, $u->id, "none"]);?>">
												Unban
											</a>
										<?php endif; ?>	
									</td>								
								<?php endif; ?>
								
							</tr>

						<?php endforeach; ?>
					</thead>
				
				</table>

				<?php if ($classroom->is_admin()):?>
					<br /><br />
					<h4>A note for teachers:</h4>
					<p>
						In order for students to join this class, they need a <em>join code</em>. <br />
						You can create one by clicking <em>show join code</em>, which is
						up there in the class header bar, on the right.
					</p>
					<br />
				<?php endif; ?>
			</div>


			<div class="tab-pane fade <?php if (Request::input("show") == "files"):?>in active<?php endif; ?>" id="files">
				<h3>
					Class Files
				</h3>

				
				<table class="table">
					
					<?php if (count($classroom->uploads)): ?>
						<?php $classroom->uploads->each(function($a) use($classroom) {?>
							<tr>
								<td>
									<a href="<?php echo url(Config::get('ringmaster.uploads_url_path')."/".$a->filename);?>" target="_blank">
										<?php echo $a->name;?>
									</a> &mdash;
									<?php echo $a->owner->prettyName();?>
									<?php if ($classroom->is_admin()):?>

										<div class="btn-group" style="float: right">
											<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="glyphicon glyphicon-trash text-muted"></span>
												Delete
											</button>
											<ul class="dropdown-menu dropdown-menu-right">
												<li>
													<a href="<?php echo action('ClassroomController@upload_detach', [$classroom->id, $a->id]);?>" method="delete" class="ajax-simple">
														<span class="glyphicon glyphicon-exclamation-sign text-muted"></span>
														Confirm delete
													</a>
												</li>
											</ul>
										</div>

										
									<?php endif;?>
								</td>
							</tr>
						<?php }); ?>
					<?php else: ?>
						<tr><td>No attachments</td></tr>
					<?php endif; ?>
					<?php if ($classroom->is_admin()):?>
						<tr>
							<td>
								<button data-show-element="#classroom_info_upload_form" class="btn btn-default btn-sm" style="float: right">
									<span class="glyphicon glyphicon-plus text-muted"></span>
									Upload a File
								</button>
								<?php echo View::make('upload._create', array(
									"id" => 				"classroom_info_upload_form", 
									"classes" => 			"display-none", 
									"upload_kind" => 		"classroom_info", 
									"belongs_to_type" => 	"classroom", 
									"belongs_to_id" => 		$classroom->id
								)); ?>
							</td>
						</tr>
					<?php endif; ?>


				</table>
			</div>
		
		<?php endif; ?>


		<?php if ($classroom->is_admin()):?>
			<div class="tab-pane fade <?php if (Request::input("show") == "settings"):?>in active<?php endif; ?>" id="settings">
				<h2>Settings</h2>

				<h3>
					Change Header Image
				</h3>
				<?php echo View::make('upload._create', array(
					"classes" =>			"col-xs-12 col-offset-sm-4 col-sm-4",
					"upload_kind" => 		"classroom_header", 
					"belongs_to_type" => 	"classroom", 
					"named" =>				false,
					"replace" =>			true,
					"belongs_to_id" => 		$classroom->id
				));?>
			</div>

		<?php endif; ?>

		</div>

	</div>

</div>