<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;




function createPDF($name, $email, $course, $uniqueID, $date){

    $flutterimg = file_get_contents(plugin_dir_path( __FILE__ ).'assets/certificate/flutter.svg');
    $twobytecodeimage = file_get_contents(plugin_dir_path( __FILE__ ).'assets/certificate/twobytecode.jpg');
    $a_sign = file_get_contents(plugin_dir_path( __FILE__ )."assets/certificate/sign-a.png");
    $d_sign = file_get_contents(plugin_dir_path( __FILE__ )."assets/certificate/sign-d.png");
    
    
    
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
                background-color: #0466C8;
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
                height: 96px;
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
                left: 190px;
                top: 84px;
                border-top: 1px solid #FAFAFA;
            }
    
            .top .part2 {
                position: absolute;
                width: 80px;
                height: 80px;
                right: 62px;
                top: 20px;
                background-color: #002549;
                border-radius: 7px;
            }
    
            .top .part2 img {
                position: relative;
                top: 10%;
                left: 10%;
                width: 80%;
                height: 80%;
                margin: auto;
            }
    
    
    
            .sub-center {
                position: relative;
                top: 20px;
                left: 55px;
            }
    
    
            .sub-center p:nth-child(1) {
                font-size: 23px;
                font-weight: 300;
                position: relative;
                text-align: left;
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
                top: 265px;
                left: -20px;
                content: "\201C";
            }
    
            q::after {
                font-family: Georgia, serif;
                position: absolute;
                font-size: 2.8em;
                line-height: 1;
                left: 337px;
                top: 385px;
                content: "\201D";
            }
    
            .sub-center p:nth-child(2) {
                margin-top: 1.5rem;
                font-weight: 500;
            }
    
    
    
            .bottom {
                width: 100%;
            }
            .bottom .part2 {
                position: absolute;
                bottom: 10px;
                right: 55px;
            }
    
            .bottom .part1 div {
                font-weight: 400;
                font-size: 10px;
                color: #ffffff;
            }
    
            .bottom .part1 div p {
                font-family: "Poppins";
                line-height: 8px;
            }
    
            .bottom .part1 div img {
                width: 40px;
                height: 40px;
                margin-left: 20%;
            }
            .bottom .part1 div.aditya {
                position: absolute;
                bottom: 3%;
                left: 12.7%;
            }
            .bottom .part1 div.divyanshu {
                position: absolute;
                bottom: 3%;
                left: 2%;
            }
            .bottom .part1 div.divyanshu p {
                border-right: 1.5px solid #ffffff;
                padding-right: 5px;
            }
    
            .bottom .part1 > p {
                font-weight: 400;
                font-size: 9px;
                color: #ffffff;
                position: absolute;
                bottom: 6px;
                left: 55px;
            }
    
    
            .bottom p.ccid {
                position: absolute;
                bottom: 7px;
                left: 320px;
                font-size: 10px;
                color: rgba(255, 255, 255, 0.4);
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
                        <p>of completion</p>
                        <span></span>
                    </div>
                </div>
                <div class="part2">
                    <img src="data:image/svg+xml;base64,'.base64_encode($flutterimg).'" alt="">
                </div>
            </div>
    
    
            <div class="sub-center">
                <p> <q id="quote">This is to certify that <span class="name">'.$name.'</span><br/>has successfully completed the <span>'.$course.'</span> <br/>course on date <span>'.$date.'</span> </q></p>
                <p>2ByteCode</p>
            </div>
    
    
    
            <div class="bottom">
                <div class="part1">
                    <div class="divyanshu">
                        <img src="data:image/jpg;base64,'.base64_encode($d_sign).'" alt="">
                        <p>Divyanshu Singh</p>
                    </div>
                    <div class="aditya">
                        <img src="data:image/jpg;base64,'.base64_encode($a_sign).'" alt="">
                        <p>Aditya Chaudhary</p>
                    </div>
                    <p>(Co-founders of 2BC)</p>
                </div>
    
                <p class="ccid">'.$uniqueID.'</p>
    
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

    $cer_name = plugin_dir_path( __FILE__ ).'certificates/course/Course-Certificate-'.bin2hex(random_bytes(3)).'.pdf';
    file_put_contents( $cer_name, $output);

}
