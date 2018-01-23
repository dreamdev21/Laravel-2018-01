<div class="section-full pv9">	
		<div class="row">
		
			<h2 class="block-title mv5" data-title="more lit"></h2>
                @foreach($pictures as $picture)        
					<div class="fs-post-table">						
						<div class="fs-table-item">


							<div class="row">
								<div class="col-sm-6 fs-table-bg" data-bg-image="assetsimages/blog/square-01.jpg">
									<img src="<img src="{{ asset('assets/images/' . $picture->image) }}"  alt="{{ $picture->title }}">" alt="$picture->title">
								</div>
								<div class="col-sm-6">
									<div class="fs-table-content">
										<h4><a href="">{{ $picture->title }}</a></h4>
										<p class="read-more">
											<a href="">read the article</a>
										</p>
									</div>
									<div class="fs-table-meta">
										<span class="pull-right"><a href="single.html"><span class="date">{{ date('F j, Y', strtotime( $picture->created_at)) }}</span></a></span>
										<div class="clearfix"></div>
									</div>
								</div>


							</div><!---row-->


						</div>
					</div>
                @endforeach
	</div>
</div>
