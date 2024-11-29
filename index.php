<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">

<!-- include header section -->
<?php include 'header.php';
include 'admin/database.php';
?>
    <!-- Start Banner -->
    <div class="ulockd-home-slider">
        <div class="container-fluid">
            <div class="row">
                <div class="pogoSlider" id="js-main-slider">
                    <div class="pogoSlider-slide" style="background-image:url(images/college_img1.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slide_text">
                                        <div class="full">
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pogoSlider-slide" style="background-image:url(images/college_img2.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slide_text">
                                        <br>
                                        <div class="full center">
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pogoSlider-slide" style="background-image:url(images/college_img4.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slide_text">
                                        <br>
                                        <div class="full center">
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pogoSlider-slide" style="background-image:url(images/college_img5.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slide_text">
                                        <br>
                                        <div class="full center">
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner -->

<!-- section -->
<div class="section margin-top_50">
        <div class="container">
            <div class="row">
                <div class="col-md-6 layout_padding_2">
                    <div class="full">
                        <div class="heading_main text_align_left">
						   <h2><span>Principal's</span>
						   Message</h2>
                        </div>
						<div class="full">
						  <p>Dear Students, Parents, and Visitors, Welcome to RVS Inter College! It is my honor and privilege to lead this esteemed institution, where education is more than academics – it is a journey of self-discovery, growth, and empowerment. At RVS Inter College, we believe in nurturing the unique talents of every student and equipping them with the knowledge, skills, and values needed to thrive in an ever-changing world.<br>

                          Our dedicated faculty, modern facilities, and robust curriculum create an enriching environment where students can excel academically and personally. Beyond the classroom, we encourage participation in extracurricular activities, fostering creativity, teamwork, and a well-rounded personality.<br>

                          As we guide our students toward a brighter future, we emphasize the importance of hard work, discipline, and ethical behavior. Together, we aim to build a community of lifelong learners, critical thinkers, and compassionate individuals.<br>

                          Thank you for choosing RVS Inter College as your partner in education. We look forward to helping you achieve your dreams and make meaningful contributions to society.
                          <br>Warm regards, 
                          <br>Principal, RVS Inter College
                          <br><h3>Awadh Raj Singh</h3>
                          </p>
						</div>
						<div class="full">
						</div>
                    </div>
                </div>
				<div class="col-md-6" id="vision_img">
                    <div class="full margin-top_50">
                        <img src="images/principal_images.jpg" alt="#" height="700px !important"/>   
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- end section -->
	<!-- section -->
    <div class="section layout_padding" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2><span>Our </span>Courses</h2>
                        </div>
					  </div>
                </div>
				<!-- Show courses from database -->
                <?php
                    $sql = "SELECT * FROM courses";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='col-md-2'> <div class='full blog_img_popular'>";
                            echo "<img class='img-responsive' style='height:120px; width:100%;' src='admin/".$row['course_image']."' alt='#' />";
                            echo "<h4 style='width:auto';>".$row['course_name']."</h4>";
                            echo "<h4 style='width:auto';>" .$row['course_description']."</h4>";
                            echo "</div></div>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
	<!-- end section -->


    <!-- section -->
    <div class="section layout_padding padding_bottom-0" id="gallery">
        <div class="container col-lg-6 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2><span>Gallery</span> Images</h2>
                        </div>
					  </div>
                </div>
			  </div>
               <div class="row">
                <?php 
                    $sql = "SELECT gallery_image FROM gallery_images";
                    $result = mysqli_query($conn, $sql);
                    
                    $images = [];
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $images[] = $row['gallery_image'];
                        }
                    }
                ?>
                <div class="col-lg-12">
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <!-- The slideshow -->
                        <div class="carousel-inner">
                        <?php
                            $total_images = count($images);
                            $slides = array_chunk($images, 2);
                            $active_class = 'active';

                            foreach ($slides as $slide) {
                                echo '<div class="carousel-item ' . $active_class . '">';
                                echo '<div class="row">';
                                
                                foreach ($slide as $image) {
                                    echo '<div class="col-lg-6 col-md-6 col-sm-12">';
                                    echo '<div class="full blog_img_popular">';
                                    echo '<a href="admin/gallery-images/' . $image . '" target="_blank"><img class="img-responsive" src="admin/gallery-images/' . $image . '" alt="#" style=" height:200px; width:400px"/></a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                
                                echo '</div>';
                                echo '</div>';

                                $active_class = ''; // remove 'active' class after the first slide
                            }
                            ?>
                            </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>

                    </div>
                </div>

            </div>			  
           </div>
        </div>
	<!-- end section -->


<!-- News and Events Section -->
<div class="section layout_padding padding_bottom-0" id="news_and_events">
    <div class="container">
        <div class="row">
            <!-- Latest News -->
            <div class="col-lg-6">
                <div class="news-section">
                    <div class="heading_main text_align_center">
                        <h2><span>Latest</span> News</h2>
                    </div>
                    <div id="news-content" class="content-container">
                        <!-- News items will be inserted here -->
                    </div>
                </div>
            </div>

            <!-- Academic Events -->
            <div class="col-lg-6">
                <div class="events-section">
                    <div class="heading_main text_align_center">
                        <h2><span>Academic</span> Events</h2>
                    </div>
                    <div id="events-content" class="content-container">
                        <!-- Event items will be inserted here -->
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>
<!-- End News and events section -->

<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                        <h2><span>Contact</span> Us</h2>
                    </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
<!-- end section -->
	
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
    <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="full float-right_img">
                    <img src="images/contact_us.jpg" alt="#" height="65%" style="margin-top: 2cm;">
                </div>
                </div>
                <div class="layout_padding col-lg-6 col-md-6 col-sm-12">
                <div class="contact_form">
                    <form action="send_email.php" method="post">
                        <fieldset>
                            <div class="full field">
                                <input type="text" placeholder="Your Name" name="name" />
                            </div>
                            <div class="full field">
                                <input type="email" placeholder="Email Address" name="email" />
                            </div>
                            <div class="full field">
                                <input type="phn" placeholder="Phone Number" name="phone" />
                            </div>
                            <div class="full field">
                                <textarea placeholder="Massage" name="message"></textarea>
                            </div>
                            <div class="full field">
                                <div class="center"><button>Send</button></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                </div>
            </div>			  
        </div>
    </div>
<!-- end section -->

<!-- Footer Section  -->
<?php include 'footer.php' ?>
<!-- Footer Section end  -->

</body>

</html>