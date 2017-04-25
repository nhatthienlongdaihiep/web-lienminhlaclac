<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-primary text-light">
						<div class="stat-panel text-center">
							<div class="stat-panel-number h1 "><?php echo $new_user;?></div>
							<div class="stat-panel-title text-uppercase">Thành viên mới</div>
						</div>
					</div>
					<a href="#" class="block-anchor panel-footer">Danh sách thành viên<i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-success text-light">
						<div class="stat-panel text-center">
							<div class="stat-panel-number h1 "><?php echo number_format($vao/100*79);?></div>
							<div class="stat-panel-title text-uppercase">Số tiền thu vào</div>
						</div>
					</div>
					<a href="#" class="block-anchor panel-footer text-center">Đã nhận 79% &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-info text-light">
						<div class="stat-panel text-center">
							<div class="stat-panel-number h1 "><?php echo number_format($tieu);?></div>
							<div class="stat-panel-title text-uppercase">Số tiền khách thuê</div>
						</div>
					</div>
					<a href="#" class="block-anchor panel-footer text-center">&nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-warning text-light">
						<div class="stat-panel text-center">
							<div class="stat-panel-number h1 "><?php echo ''.number_format($thue['tgian']/60/60).'/'.$thue['luot'].'';?></div>
							<div class="stat-panel-title text-uppercase">Số giờ/Số lượt</div>
						</div>
					</div>
					<a href="#" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>