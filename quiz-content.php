<section class="quiz-page">
    <div class="container py-4 py-lg-5">

        <div class="quiz-wrapper py-2 px-0 px-lg-5 pb-lg-5 pt-lg-3">

            <div class="row">

                <div class="col-md-6">
                    <div class="quiz-part1 p-2 p-lg-4 mb-5 mb-md-0">

                        <div class="row">
                            <div class="col-6">
                                <p class="question-count">Question 0 of 10</p>
                            </div>
                            <div class="col-6">
                                <p class="float-end total-score d-none">Total Score: 0</p>
                            </div>
                        </div>

                        <div class="quiz-inner-wrapper pb-1">
                            <div class="question_wrapper mb-3">
                                <h4 class="question mb-0">
                                </h4>
                                <p class="small d-none">Choose one or more options</p>
                            </div>

                            <div class="options pb-2">

                            </div>
                        </div>

                        <button type="button" class="btn btn-primary mt-4 px-4 py-2 fs-5" id="quiz-submit">Next <i class="bi bi-caret-right-fill"></i></button>

                    </div>



                    <div class="quiz-result p-2 p-lg-4 mb-5 mb-md-0">

                        <div class="animation">
                            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_jR229r.json" background="transparent" speed="1" class="lottie-firework"></lottie-player>
                        </div>

                        <div class="result-wrapper">

                            <div class="d-flex flex-column align-items-center">
                                <div class="pie animate" style="--c:green"></div>
                                <p class="tag mt-2 fs-5"></p>
                                <a href="/quiz/" class="btn btn-primary mt-4 px-4 py-2 fs-5">Restart Quiz <i class="bi bi-caret-right-fill"></i> </a>
                            </div>

                        </div>

                        <div class="recomendation">
                            <div class="contentWrap mt-5">
                                <div class="card" style="max-width: 350px; flex: 0 0 72%;">
                                    <a href="/dart/">
                                        <div class="card-img disabled">
                                            <img src="<?php echo get_template_directory_uri() . '/images/dart.png'; ?>" />
                                            <div class="centeredText fs-2 text-black">Read<br/> Dart <br/>Documentation</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="show-courses d-none">
                            <h2>Recomended courses just for you ...</h2>
                            <p class="text-muted">Learn and boost your knowledge with us</p>

                            <div class="row gap-3">

                                <div class="col-sm-5">
                                    <div class="card">
                                        <img src="http://localhost/wordpress/wp-content/plugins/tutor/assets/images/placeholder.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Basic Flutter Course</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary px-3">Learn</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="card">
                                        <img src="http://localhost/wordpress/wp-content/plugins/tutor/assets/images/placeholder.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Basic Flutter Video Course</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary px-3">Learn</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="card">
                                        <img src="http://localhost/wordpress/wp-content/plugins/tutor/assets/images/placeholder.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Intermidiate Flutter Course</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary px-3">Learn</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="card">
                                        <img src="http://localhost/wordpress/wp-content/plugins/tutor/assets/images/placeholder.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Intermidiate Flutter Video Course</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary px-3">Learn</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- part2 -->
                <div class="col-md-6">

                    <div class="card bg-transparent border-0 quiz-part2 px-1 py-4 p-md-4 pt-md-3 my-3 my-md-0">
                        <h2>
                        Flutter 4 Freelancer Course
                        </h2>
                        <p>Learn to freelance with this 4 in 1 flutter course !!</p>
                        <img src="<?php echo get_template_directory_uri().'/images/auth-banner.jpeg'; ?>" alt="" class="m-auto pt-3">
                    </div>

                    <div class="card bg-transparent border-0 quiz-part2 px-1 py-5 my-1 my-md-0 p-lg-4 mt-3 mt-md-0 certificate-form d-none">
                        <h2>
                            😍 Download your Certificate
                        </h2>
                        <p>Fill the form below and download your certificate.</p>

                        <form action="<?php echo admin_url('admin-ajax.php'); ?>" class="row col-12 certificate-form" id="certificate-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" name="cer-name" id="cer-name" placeholder="Your Name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="text" class="form-control" name="cer-email" id="cer-email" placeholder="Your Email">
                            </div>
                            <?php wp_nonce_field('quizCertificateDownload2BC'); ?>
                            <input type="hidden" name="level">

                            <div class="mb-3">
                                <button type="submit" class="btn py-2 d-flex justify-content-between btn-secondary w-50"><span> Download</span> <i class="bi bi-arrow-right"></i></a></button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
