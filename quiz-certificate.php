<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;




function createPDF($name, $email, $level, $UniqueID){

    $flutterimg = file_get_contents(plugin_dir_path( __FILE__ ).'assets/certificate/flutter.svg');
    $twobytecodeimage = file_get_contents(plugin_dir_path( __FILE__ ).'assets/certificate/twobytecode.jpg');

    // end quote position
    $leftendquote = 680;
    if($level == "Intermediate"){
        $leftendquote = 706;
    }
    if($level == "Expert"){
        $leftendquote = 670;
    }




$fileContent = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>

    <style>

        @font-face {
            font-family: "Poppins";
            src: url("'.plugin_dir_path( __FILE__ ).'assets/certificate/fonts/Poppins-Bold.ttf");
            format("truetype");
            font-weight: 500;
        }
        @font-face {
            font-family: "Poppins";
            src: url("'.plugin_dir_path( __FILE__ ).'assets/certificate/fonts/Poppins-SemiBold.ttf");
            format("truetype");
            font-weight: 600;
        }
        @font-face {
            font-family: "Poppins";
            src: url("'.plugin_dir_path( __FILE__ ).'assets/certificate/fonts/Poppins-Light.ttf");
            format("truetype");
            font-weight: 300;
        }
        @font-face {
            font-family: "Poppins";
            src: url("'.plugin_dir_path( __FILE__ ).'assets/certificate/fonts/Poppins-Regular.ttf");
            format("truetype");
            font-weight: 400;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins";
        }

        body {
            width: 850px;
            height: 675px;
        }

        div.center {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: #151515;
            color: #fff;
            padding: 20px;
        }

        .top,
        .sub-center,
        .bottom {
            height: 216px;
            max-height: 216px;
        }

        .top {
            padding-left: 25px;
            padding-top: 25px;
            padding-right: 25px;
        }
        .top .textpart {
            position: relative;
            border-left: 7px solid #fff;
            text-indent: 10px;
            font-weight: 300;
            height: 100px;
        }
        .top .textpart h1 {
            position: relative;
            top: -41px;
            font-size: 70px;
            font-weight: 300;
            line-height: 50px;
        }
        .top .textpart p {
            position: relative;
            top: -60px;
            font-size: 22px;
            text-indent: 25px;
        }
        .top .textpart span {
            position: absolute;
            width: 150px;
            height: 0px;
            left: 210px;
            top: 82px;
            border-top: 1px solid #FAFAFA;
        }
        .top .part2 {
            position: absolute;
            width: 80px;
            height: 80px;
            right: 65px;
            top: 55px;
        }
        .top .part2 img {
            width: 100%;
            height: 100%;
        }

        .sub-center {
            position: relative;
            top: 45px;
            left: -50px;
        }
        .sub-center p:nth-child(1) {
            font-size: 23px;
            font-weight: 300;
            position: relative;
            text-align: center;
        }
        .sub-center p:nth-child(1) span {
            font-weight: 600;
        }
        .sub-center p:nth-child(1) q .name {
            font-weight: 600;
            font-size: 28px;
        }
        q{
            position: relative;
        }
        q::before {
            font-family: Georgia, serif;
            position: absolute;
            font-size: 2.8em;
            line-height: 1;
            top: 245px;
            left: 265px;
            content: "\201C";
        }
        q::after {
            font-family: Georgia, serif;
            position: absolute;
            font-size: 2.8em;
            line-height: 1;
            left: '.$leftendquote.'px;
            top: 390px;
            content: "\201D";
        }
        .sub-center p:nth-child(2) {
            margin-top: 3rem;
            margin-left: 510px;
            font-weight: 300;
        }
        .sub-center p:nth-child(2) span {
            font-weight: 600;
        }

        .bottom {
            width: 100%;
        }
        .bottom .part1 {
            position: absolute;
            bottom: 10px;
        }
        .bottom .part2 {
            position: absolute;
            bottom: 10px;
            right: 55px;
        }

        .bottom .part1 p {
            font-weight: 300;
            font-size: 12px;
            line-height: 36px;
            color: rgba(255, 255, 255, 0.7);
            position: relative;
            bottom: -60px;
        }

        .bottom .part1 p:last-child {
            position: relative;
            font-weight: 300;
            font-size: 10px;
            line-height: 36px;
            color: rgba(255, 255, 255, 0.4);
            left: 300px;
            top: 0;
        }
        
        .bottom .part2 p {
            font-weight: 300;
            font-size: 11px;
            line-height: 30px;
        }
        .bottom .part2 img {
            width: 130px;
            height: 38px;
            border-radius: 2px;
        }

    </style>
</head>

<body>

    <div class="center">

        <div class="top">
            <div class="part1">
                <div class="textpart">
                    <h1>Certificate</h1>
                    <p>of achievement</p>
                    <span></span>
                </div>
            </div>
            <div class="part2">
                <img src="data:image/svg+xml;base64,'.base64_encode($flutterimg).'" alt="">

            </div>
        </div>

        <div class="sub-center">
            
            <p> <q id="quote">This is to certify that, <br/> <span class="name">'.$name.'</span><br />is a <span>'.$level.' level</span>
                    flutter developer. </q></p>

            <p>~ <span> 2ByteCode</span>.in</p>
            
        </div>

        <div class="bottom">
            <div class="part1">
                <p>Visit to 2bytecode.in</p>
                <p>'.$UniqueID.'</p>
            </div>
            <div class="part2">
                <p>Issued By</p>
                <img src="data:image/jpg;base64,'.base64_encode($twobytecodeimage).'" alt="">
            </div>
        </div>

    </div>

</body>

</html>';


    $dompdf = new Dompdf();
    $dompdf->loadHtml($fileContent);
    $customPaper = array(0,0,638,536.48);
    $dompdf->setPaper($customPaper);
    $dompdf->render();
    $output = $dompdf->output();


    ob_start();
    include 'quiz-mail.php';
    $mail_body = ob_get_clean();

    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    $cer_name = plugin_dir_path( __FILE__ ).'certificates/quiz/Quiz-Certificate-'.bin2hex(random_bytes(3)).'.pdf';
    if(file_put_contents( $cer_name, $output) ) {
        $attachments = array($cer_name);
        if(wp_mail($email, "YOUR CERTIFICATE BY 2BC", $mail_body, $headers, $attachments)){
            unlink($cer_name);
            $response['success'] = true;
            $response['data'] = "<h4 style='color:rgb(12,12,12)'>SUCCESS!</h4><br><p>We received your response.<br>Certificate will arrive soon via mail. </p>";
        }
    }else{
        $response['success'] = false;
        $response['data'] = "<h4 style='color:rgb(12,12,12)'>Error #CF-M</h4><br><p>Please Try again later</p>";
    }

    
    return $response;

}


