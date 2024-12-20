    <!-- Start Footer -->
    <footer class="footer-box">
        <div class="container">
		
		   <div class="row">
		   
		      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			     <div class="footer_blog">
				    <div class="full margin-bottom_30">
					   <!-- <img src="images/footer_logo.png" alt="#" /> -->
					   <a class="navbar-brand" id="logo" href="index.php">RVS Inter Collge</a>
					   </div>
					 <div class="full white_fonts">
					    <p>RVS Inter College is a premier institution dedicated to academic excellence and holistic development. Located in a serene and inspiring environment, our college is committed to nurturing the leaders of tomorrow through quality education and value-based learning. </p>
					 </div>
				 </div>
			  </div>
			  
			  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			       <div class="footer_blog footer_menu white_fonts">
						    <h3>Quick links</h3>
						    <ul> 
							  <li><a href="about.php">> About Us</a></li>
							  <li><a href="contact.php">> Contact Us</a></li>
							  <li><a href="admission.php">> Admission</a></li>
							  <li><a href="index.php#news_and_events">> News & Events</a></li>
							  <li><a href="https://swayam.gov.in" target="_blank">> Swayam</a></li>
							</ul>
						 </div>
				 </div> 
			  
			  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				 <div class="footer_blog full white_fonts">
						     <h3 id="contact_us">Contact us</h3>
							 <ul class="full">
							   <li><img src="images/i5.png"><span>RVS Inter College Tiloi, Amethi, Uttar Pradesh Pin Code - 229309</span></li>
							   <li><img src="images/i6.png"><a href="mailto:gctodabhim@gmail.com"><span>rvsintercollge@gmail.com</span></a></li>
							   <li><img src="images/i7.png"><a href="tel:+91 9785954219"><span>+91 9838078783</span></a></li>
							 </ul>
						 </div>
					</div>	
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				 <div class="footer_blog full white_fonts">
						     <h3>View Map</h3>
							 <div class="map">
      							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14295.115536076171!2d81.4800746!3d26.3983304!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bb310dba62a87%3A0xacdcf3e5531465b9!2sR%20V%20S%20Inter%20College!5e0!3m2!1sen!2sin!4v1732895649382!5m2!1sen!2sin" height="300px;" width="320px;"></iframe>
									
		                    </div>
						 </div>
					</div>	 
		   </div>
		
        </div>
    </footer>
    <!-- End Footer -->

    <div class="footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="crp">&copy;<?php echo date('Y');?> All Rights Reserved to RVS Inter College Developed by: <a href="#">Nadim Ahmad</a></p>
                </div>
            </div>
        </div>
    </div>

    <a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>
    <!-- ALL JS FILES -->
    <script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.pogo-slider.min.js"></script>
    <script src="js/slider-index.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/custom.js"></script>
	<script>
	/* counter js */

(function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});
</script>