<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alumni Tracking System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
    <link rel="icon" href="images/logo.ico" type="image/logo">
    <link href="table.css" type="text/css" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Shrikhand', sans-serif;    
        }

        body {
            background: url('images/schoolback.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(243, 243, 243, 0.7);
            z-index: -1;
        }

        .top_banner {
            height: 120px;
            width: 100%;
            background: transparent;
        }

        .in_banner {
            width: 100%;
            margin: 0 auto;
            height: 120px;
            background: transparent;
        }

        .banner_text {
            float: left;
            width: 1000px;
            margin: 37px 0 0 30px;
            text-align: left;
        }

        .banner_text h1 {
            font-size: 25pt;
            color: #222222;
            margin: 0;
            padding: 0;
            font-weight: normal;
            font-family: 'Shrikhand', cursive;
        }

        .banner_text h2 {
            font-size: 25pt;
            color: #222222;
            margin: 0;
            margin-top: -20px;
            padding: 0;
            font-weight: normal;
            font-family: 'Noticia Text', serif;
        }

        .glogo {
            width: 102px;
            height: 120px;
            float: left;
            margin: 0px 5px 0 5px;
        }

        .logo {
            float: left;
            width: 107px;
            height: 112px;
            margin: 20px 0 0 20px;
            cursor: pointer;
            z-index: 10; 
            position: relative; 
        }

        .wavy-sidebar {
            position: fixed;
            left: -800px; 
            top: 0;
            width: 800px;
            height: 100vh;
            background-color: #a00c30;
            color: white;
            padding: 20px;
            clip-path: path('M 0 0 C 250 20, 50 150, 260 220 C 500 300, 200 500, 450 660 C 700 800, 1000 1000, 600 1000 L 0 1000 Z');
            z-index: 2; 
            transition: left 0.5s ease; 
        }

        .wavy-sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 150px;
        }

        .wavy-sidebar li {
            margin: 20px 0;
        }

        .wavy-sidebar li a {
            display: block;
            text-decoration: none;
            color: white; 
            font-size: 30px;
            font-family: 'Noticia Text', serif;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.3s ease, padding 0.3s ease;
        }

        .wavy-sidebar li a:hover {
            color: #FE0000; 
            padding-left: 20px; 
            font-weight: bolder;
        }

        .wavy-sidebar li a.active {
            color: #222222;         
            font-weight: bold;     
        }

        footer {
            background-color: #a00c30;
            padding: 5px 5px;
            color: white;
            text-align: center;
            font-family: 'Shrikhand', sans-serif;
            position: fixed;  
            bottom: 0;       
            left: 0;          
            width: 100%;      
            z-index: 3; 
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .quote {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #fafafa;
        }

        .footer-content {
            display: flex;             
            justify-content: center;   
            gap: 100px;             
            margin: 10px 0;          
            width: 100%;             
        }

        .footer-item {
            background-color: #222222;
            padding: 10px 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;     
            justify-content: center;   
            gap: 10px;
            font-size: 1.1rem;
            font-family: 'Noticia Text', serif;
            flex: 1;                   
            text-align: center;        
        }

        .footer-location {
            margin: 10px 0;            
            font-size: 1.1rem;
            font-family: 'Noticia Text', serif;
        }

        .footer-item i, .footer-location i {
            display: inline-block;
            color: white;
            font-size: 1.3rem;
        }

        .footer-text {
            font-family: 'Courier New', monospace; 
            font-weight: bold;
            font-size: 1.2rem;
            color: #222222;
        }

        .fas.fa-map-marker-alt {
            color: #fafafa;
        }

        .facebook-link a {
            color: #fafafa;
            text-decoration: none; 
        }

        .facebook-link a:hover {
            text-decoration: underline; 
        }

        .slideshow-container {
            max-width: 810px;
            position: relative;
            margin: 0;
            text-align: center;  
            float: right;        
            margin-right: 100px;  
            border: 10px solid #fafafa; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
        }
        .slide {
            display: none;
            width: 80%;  
            margin: auto;  
            height: auto; 
        }
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }
        @keyframes fade {
            from {
                opacity: 0.4;
            }
            to {
                opacity: 1;
            }
        }
<<<<<<< Updated upstream
=======

        .icon-btn {
        position: absolute; /* Ensure proper placement within the slideshow container */
        top: 50%; /* Vertically center the buttons */
        transform: translateY(-50%); /* Adjust for proper centering */
        background-color: rgba(0, 0, 0, 0.1); /* Semi-transparent background */
        color: white; /* Icon color */
        border: none; /* Remove default border */
        padding: 5px; /* Add padding for better touch area */
        cursor: pointer; /* Pointer cursor for better UX */
        z-index: 1000; /* Ensure the buttons are above other elements */
        border-radius: 25%; /* Rounded buttons */
    }

    #prevBtn {
        left: 10px; /* Position to the left */
    }

    #nextBtn {
        right: 10px; /* Position to the right */
    }

    .icon-btn i {
        font-size: 20px; /* Adjust icon size */
    }

    .icon-btn:hover {
        background-color: rgba(0, 0, 0, 0.7); /* Darken background on hover */
    }


>>>>>>> Stashed changes
    </style>
</head>
<body>
<form name="aspnetForm" method="post" action="main.php">
    <div class="top_banner">
        <div class="in_banner">
            <div class="logo">
                <img alt="jee" src="images/banner.png">
            </div>
            <div class="banner_text">
                <h1>SACRED HEART OF JESUS CATHOLIC SCHOOL</h1>
                <h2>HOME OF THE MEEK AND HUMBLE</h2>
            </div>
        </div>
    </div>

    <div class="wavy-sidebar">
        <ul>
            <li><a href="LandingPage.php" class="active">Home</a></li>
            <li><a href="SHJCSPage.php">SHJCS</a></li>
            <li><a href="Frontend/login.php">Alumni Tracker</a></li>
        </ul>
    </div>
=======
    <div class="slideshow-container" style="position: relative;">
    <!-- Slide 1 -->
    <img class="slide fade" src="images/slide1.jpg" style="width:100%">
    <!-- Slide 2 -->
    <img class="slide fade" src="images/slide2.jpg" style="width:100%">
    <!-- Slide 3 -->
    <img class="slide fade" src="images/slide3.jpg" style="width:100%">

    <button id="prevBtn" type="button" class="icon-btn">
    <i class="fas fa-chevron-left"></i>
    </button>
    <button id="nextBtn" type="button" class="icon-btn">
    <i class="fas fa-chevron-right"></i>
</button>
</div>
>>>>>>> Stashed changes

    <footer>
        <div class="footer-container">
            <p class="quote">JESUS MEEK AND HUMBLE OF HEART, MAKE OUR HEARTS LIKE UNTO THINE</p>
            <div class="footer-content">
                <div class="footer-item">
                    <i class="fas fa-phone"></i>
                    <span>8478-3769</span>
                </div>
                <div class="footer-item">
                    <i class="fab fa-facebook"></i>
                    <span><div class="facebook-link"><a href="https://www.facebook.com/SHJCSOFFICIAL/">SHJCSOFFICIAL</a></div></span>
                </div>
                <div class="footer-item">
                    <i class="fas fa-envelope"></i>
                    <span>shjcssat.mesa@gmail.com</span>
                </div>
            </div>
            <div class="footer-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>4324 OLD STA. MESA, MANILA</span>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Toggle sidebar when logo is clicked
    $('.logo').click(function() {
        var sidebar = $('.wavy-sidebar');
        if (sidebar.css('left') === '0px') {
            sidebar.css('left', '-800px');
        } else {
            sidebar.css('left', '0px');
        }
    });

    let slideIndex = 0;
    let slideTimer; // To store the auto-slide timer

    function showSlides() {
        let slides = document.getElementsByClassName("slide");

        // Ensure there are slides before proceeding
        if (slides.length === 0) {
            console.error("No slides found!");
            return;
        }

        // Hide all images by default
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        // Show the current slide
        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1; }    
        slides[slideIndex - 1].style.display = "block";    

        // Call the function every 3 seconds
        slideTimer = setTimeout(showSlides, 3000);
    }

    function nextSlide() {
        clearTimeout(slideTimer); // Stop the current timer
        let slides = document.getElementsByClassName("slide");

        // Hide current slide
        slides[slideIndex - 1].style.display = "none";

        // Move to the next slide
        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1; }

        // Show the new slide
        slides[slideIndex - 1].style.display = "block";

        // Restart the slideshow timer
        slideTimer = setTimeout(showSlides, 3000);
    }

    function prevSlide() {
        clearTimeout(slideTimer); // Stop the current timer
        let slides = document.getElementsByClassName("slide");

        // Hide current slide
        slides[slideIndex - 1].style.display = "none";

        // Move to the previous slide
        slideIndex--;
        if (slideIndex < 1) { slideIndex = slides.length; }

        // Show the new slide
        slides[slideIndex - 1].style.display = "block";

        // Restart the slideshow timer
        slideTimer = setTimeout(showSlides, 3000);
    }

    // Attach event listeners to buttons
    document.getElementById("nextBtn").addEventListener("click", nextSlide);
    document.getElementById("prevBtn").addEventListener("click", prevSlide);

    showSlides(); // Start the slideshow
});



</script>
</form>
</body>
</html>

