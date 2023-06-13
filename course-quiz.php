<?php

if (!is_user_logged_in() || !isset($_GET["course-id"]) || empty($_GET["course-id"]) || !is_numeric(($_GET["course-id"]))) {
    wp_redirect(get_home_url());
    die();
}

global $wpdb;
$course_id = (int)sanitize_text_field($_GET["course-id"]);
$course_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE ID=$course_id");
if(empty($course_data)){
    die("Unable to find course");
}
$course_data = $course_data[0];
if($course_data->post_status != "publish" || $course_data->post_type != "courses"){
    die("Incorrect course id");
}

$is_enrolled = tutor_utils()->is_enrolled($course_id);
if(!$is_enrolled){
    die("You have'nt enrolled for this course");
}

?>

<div class="course-quiz container">

    <div class="title mt-3">
        <fieldset>
            <legend>Certificate Test: <b><?php echo $course_data->post_title; ?></b></legend>
        </fieldset>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="quiz-part1 p-2 p-lg-4 pt-1 pt-lg-1 mb-5 mb-md-0">

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
                        <h4 class="question mb-0 py-3 px-4">
                        1. <span>Hello world some random question will go here, this is random data?</span>
                        </h4>
                        <p class="small d-none">Choose one or more options</p>
                    </div>

                    <div class="options pb-2">

                        <div class="mb-3 py-1">
                            <input type="radio" class="btn-check" name="answer" value="1" id="option-1" autocomplete="off">
                            <label class="btn btn-outline-primary option px-4 py-2" for="option-1">A. Option</label>
                        </div>

                        <div class="mb-3 py-1">
                            <input type="radio" class="btn-check" name="answer" value="1" id="option-2" autocomplete="off">
                            <label class="btn btn-outline-primary option px-4 py-2" for="option-2">B. Option</label>
                        </div>

                        <div class="mb-3 py-1">
                            <input type="radio" class="btn-check" name="answer" value="1" id="option-3" autocomplete="off">
                            <label class="btn btn-outline-primary option px-4 py-2" for="option-3">C. Option</label>
                        </div>

                        <div class="mb-3 py-1">
                            <input type="radio" class="btn-check" name="answer" value="1" id="option-4" autocomplete="off">
                            <label class="btn btn-outline-primary option px-4 py-2" for="option-4">D. Option</label>
                        </div>

                    </div>
                </div>

                <div class="hstack mt-4">
                    <button type="button" class="btn btn-primary shadow-sm" id="course-quiz-prev"><i class="bi bi-chevron-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary shadow-sm ms-auto" id="course-quiz-next">Next <i class="bi bi-chevron-right"></i></button>
                </div>

            </div>
        </div>
    </div>