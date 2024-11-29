

<body id="inner_page" data-spy="scroll" data-target="#navbar-wd" data-offset="98">

	<?php include 'header.php'; ?>
	<!-- section -->
	
	<section class="inner_banner">
	  <div class="container">
	      <div class="row">
		      <div class="col-12">
			     <div class="full">
				     <h3>About us</h3>
				 </div>
			  </div>
		  </div>
	  </div>
	</section>
	
	<!-- end section -->
   
	<!-- section -->
    <div class="section margin-top_50">
        <div class="container">
            <div class="row">
                <div class="col-md-6 layout_padding_2" id="principal_message">
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
						   <!-- <a class="hvr-radial-out button-theme" href="#">About more</a> -->
						</div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="full">
                        <img src="images/principal_images.jpg" alt="#" style="height:700px !important; margin-top:2cm"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- end section -->
	<!-- section -->
    <div class="section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2 id="mission_vission"><span>Mission & </span>Vission</h2>
                        </div>
						<p align='center' style="font-weight:400">At RVS Inter College, our mission is to provide a transformative educational experience that nurtures academic excellence, fosters holistic development, and instills ethical values in students. We are committed to creating an inclusive, inspiring environment where students can explore their potential, embrace lifelong learning, and become responsible, compassionate citizens contributing positively to society.

							<br>Our vision is to emerge as a center of educational excellence, empowering students to lead with knowledge, integrity, and innovation. We aspire to build a community of learners equipped with the skills, confidence, and values to thrive in a dynamic, globalized world while staying grounded in cultural heritage and humanistic principles.

							<br>Let me know if you’d like these tailored further to highlight specific aspects of your college’s focus, such as technology, cultural programs, or leadership!</p>
					  </div>
                </div>
            </div>
        </div>
    </div>
	<!-- end section -->

	<!-- section -->
    <div class="section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2 id="grievance_redressal_cell"><span>Grievance </span>Redressal Cell</h2>
                        </div>
						<p style="font-weight:400; text-align: justify;">At RVS Inter College, we are committed to maintaining a supportive and inclusive environment for all students, faculty, and staff. The Grievance Redressal Cell is established to address and resolve concerns, complaints, or grievances in a fair, transparent, and efficient manner.</p>
                        <b>Objectives of the Grievance Redressal Cell-</b>
                        <ol>
                            <li>1. To provide a platform for students, parents, and staff to voice their concerns.</li>
                            <li>2. To ensure a prompt and impartial resolution of grievances.</li>
                            <li>3. To promote a harmonious and respectful atmosphere within the college community.</li>
                            <li>4. To safeguard the rights and dignity of every individual at the institution.</li>
                        </ol>
                        <br><br>
						<ul>
							<li><b>Email:</b> rvsintercollege@gmail.com</li>
							<li><b>Phone:</b> +91 9838078783</li>
							<li><b>Office Hours:</b> Monday to Saturday, 10:00 AM to 5:00 PM</li>
							<li><b>Location:</b> RVS Inter College, Tiloi, Amethi, Uttar Pradesh, Pin Code - 229309</li>
						</ul>
					  </div>
                </div>
            </div>
        </div>
    </div>
	<!-- end section -->

    
    <!-- section -->
    <div class="section layout_padding padding_bottom-0" id="gallery">
        <div class="container" id="about-gallery">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2><span>Gallery</span></h2>
                        </div>
					  </div>
                </div>
			  </div>
               <div class="row">
                <?php 
                    include 'admin/database.php';
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
                                    echo '<div class="full blog_img_popular mb-20" style="height:400px !important">';
                                    echo '<img class="img-responsive" src="admin/gallery-images/' . $image . '" alt="#" style=" height:600px; width:600px"/>';
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


<!-- Footer Section  -->
<?php include 'footer.php' ?>
<!-- Footer Section end  -->

</body>

</html>