@include('appLayout.app')
@include('appLayout.nav')
@include('components.loader')

@include('components.hero')


	<!-- Modal to embed vidoes!! -->
	<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content border-0" style="border-radius: 0.75rem;">
				<div class="modal-header border-0 p-0">
					<button type="button" class="btn-close bg-white border position-absolute top-0 end-0 translate-middle me-n3 me-sm-n5 mt-n4 rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-0">
					<div class="ratio ratio-16x9">
						<iframe class="embed-responsive-item iframeVideo" style="border-radius: 0.75rem;" allow="autoplay"></iframe>
					</div>
				</div>
				
			</div>
		</div>
	</div>



	<!-- services -->
	<div class="overflow-hidden py-7 py-sm-8 py-xl-9 bg-body-tertiary">
	    <div class="container">
	        <div>
	            <div class="mx-auto max-w-2xl text-center">
					
	                <p class="m-0 mt-2 text-body-emphasis text-4xl tracking-tight fw-bold">
                        We’re not just for dating
	                </p>
	                {{-- <p class="m-0 mt-4 text-body text-lg leading-8">
	                    Experience the power of eco-friendly laundry with our premium detergents
	                </p> --}}
	            </div>
	        </div>
            <div>
                <div class="row row-cols-1 row-cols-xl-3 gy-5 gx-xl-4 mt-1 justify-content-center justify-content-xl-between">
                    @foreach($users as $user)
                    <div class="col pt-5 pt-xl-4">
                        <div class="max-w-xl mx-auto mx-xl-0" data-aos-delay="0" data-aos="fade" data-aos-duration="1000">
                            <div class="ratio" style="--bs-aspect-ratio: 66.66%;">
                                <img src="{{ asset('storage/' . $user->profile_picture)  ?? 'https://via.placeholder.com/40' }}" class="object-fit-cover rounded-3" alt="User image" loading="lazy">
                            </div>
            
                            <h3 class="m-0 mt-4 text-body-emphasis text-lg leading-6 fw-semibold">
                                {{ $user->name }}
                            </h3>
            
                            <!-- Remove line-clamp-2 if you need more lines or add line-clamp-3 -->
                            <p class="m-0 mt-3 text-body-secondary line-clamp-2 text-sm leading-6">
                                {{ $user->bio }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

	        <div class="text-center pt-7">
	            <a href="javascript:;" class="btn btn-lg btn-primary text-white icon-link icon-link-hover text-sm leading-6 fw-semibold">
                    Learn more 
                    <span class="bi align-self-start left-to-right" aria-hidden="true">→</span>
                    <span class="bi align-self-start right-to-left" aria-hidden="true">←</span>
                </a>
	        </div>
	    </div>      
	</div>	



	<!-- About Us -->
	<div class="overflow-hidden py-7 py-sm-8 py-xl-9">
		<div class="container">
			<div class="row gy-5 align-items-center justify-content-between">
				<div class="col-12 col-xl-5 order-last">
					<div class="mx-auto max-w-2xl">
						
						<p class="m-0 mt-2 text-body-emphasis text-4xl tracking-tight fw-bold">
							Make the first move™
						</p>
						<p class="m-0 mt-4 text-body-secondary text-lg leading-8">
							We’re the only app that makes dating better by putting women’s experiences first. Because when things are better for women, they’re better for everyone.
						</p>
						<div class="mt-4">
							<a href="javascript:;" class="icon-link icon-link-hover text-decoration-none text-sm leading-6 fw-bold">
			                    Learn more 
			                    <span class="bi align-self-start left-to-right" aria-hidden="true">→</span>
			                    <span class="bi align-self-start right-to-left" aria-hidden="true">←</span>
			                </a>
						</div>
					</div>
				</div>

				<div class="col-12 col-xl-6">
					<div class="mx-auto max-w-2xl">
                        <div class="ratio ratio-4x3" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
                            <img src="./assets/img/bg/bg5.jpg" class="object-fit-cover rounded-3" alt="about us" loading="lazy">
                        </div>
					</div>
				</div>
			</div>

			<!-- big image -->
		    <div class="ratio ratio-16x9 mt-7 mt-sm-8 mt-xl-9">
                <img src="./assets/img/bg/bg6.jpg" class="object-fit-cover rounded-3" alt="presentation" loading="lazy">
            </div>
		</div>
	</div>



   <!-- Testimonials -->
<div class="overflow-hidden py-7 py-sm-8 py-xl-9 bg-body-secondary">
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide pb-5">
            <div class="carousel-indicators mb-0">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="mx-auto max-w-4xl text-center">
                        <h1 class="mx-auto">If they found love, so can you!</h1>
                        <figure class="m-0 mt-5">
                            <blockquote class="text-center fw-semibold text-body-emphasis text-2xl leading-9">
                                <p class="m-0">
                                    “I met my soulmate through this amazing dating app! The process was seamless, and I was matched with someone who shares my interests. Can't thank you enough for bringing us together!” 
                                </p>
                            </blockquote>

                            <figcaption class="m-0 mt-5">
                                <img class="mx-auto rounded-circle" width="40" height="40" src="./assets/img/small-team/st1.jpg" alt="Client Name" loading="lazy">
                                <div class="mt-3 d-flex align-items-center justify-content-center text-base">
                                    <div class="fw-semibold text-body-emphasis">Emily Parker</div>
                                    <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="mx-3 text-body-emphasis" fill="currentColor">
                                        <circle cx="1" cy="1" r="1" />
                                    </svg>
                                    <div class="text-body-secondary">Content Creator</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="mx-auto max-w-4xl text-center">
                        <h1 class="mx-auto">If they found love, so can you!</h1>
                        <figure class="m-0 mt-5">
                            <blockquote class="text-center fw-semibold text-body-emphasis text-2xl leading-9">
                                <p class="m-0">
                                    “Thanks to this platform, I found a partner who truly understands me. The variety of profiles made it easy to connect with like-minded people. Highly recommend!” 
                                </p>
                            </blockquote>

                            <figcaption class="m-0 mt-5">
                                <img class="mx-auto rounded-circle" width="40" height="40" src="./assets/img/small-team/st2.jpg" alt="Client Name" loading="lazy">
                                <div class="mt-3 d-flex align-items-center justify-content-center text-base">
                                    <div class="fw-semibold text-body-emphasis">Michael Smith</div>
                                    <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="mx-3 text-body-emphasis" fill="currentColor">
                                        <circle cx="1" cy="1" r="1" />
                                    </svg>
                                    <div class="text-body-secondary">Software Engineer</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="mx-auto max-w-4xl text-center">
                        <h1 class="mx-auto">If they found love, so can you!</h1>
                        <figure class="m-0 mt-5">
                            <blockquote class="text-center fw-semibold text-body-emphasis text-2xl leading-9">
                                <p class="m-0">
                                    “I had given up on dating, but this app made it so easy to meet amazing people. I've now been happily dating someone for three months. Thank you!” 
                                </p>
                            </blockquote>

                            <figcaption class="m-0 mt-5">
                                <img class="mx-auto rounded-circle" width="40" height="40" src="./assets/img/small-team/st3.jpg" alt="Client Name" loading="lazy">
                                <div class="mt-3 d-flex align-items-center justify-content-center text-base">
                                    <div class="fw-semibold text-body-emphasis">Sophie Turner</div>
                                    <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="mx-3 text-body-emphasis" fill="currentColor">
                                        <circle cx="1" cy="1" r="1" />
                                    </svg>
                                    <div class="text-body-secondary">Marketing Specialist</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev d-none d-xl-inline" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon rtl-flip" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next d-none d-xl-inline" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon rtl-flip" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>


@include('appLayout.footer')