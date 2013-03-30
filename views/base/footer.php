<div class="row">
	<div class="twelve columns">
		<h3>Reveal</h3>

		<p><a href="#" data-reveal-id="exampleModal" class="button">Example modal</a></p>
	</div>
</div>
<div id="exampleModal" class="reveal-modal">
	<h2>This is a modal.</h2>

	<p>
		Reveal makes these very easy to summon and dismiss. The close button is simple an anchor with a unicode
		character icon and a class of <code>close-reveal-modal</code>. Clicking anywhere outside the modal will
		also dismiss it.
	</p>
	<a class="close-reveal-modal">×</a>
</div>
<!-- Included JS Files (Uncompressed) -->
<!--
  <script src="javascripts/jquery.js"></script><script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script><script src="javascripts/jquery.foundation.forms.js"></script><script src="javascripts/jquery.foundation.reveal.js"></script><script src="javascripts/jquery.foundation.orbit.js"></script><script src="javascripts/jquery.foundation.navigation.js"></script><script src="javascripts/jquery.foundation.buttons.js"></script><script src="javascripts/jquery.foundation.tabs.js"></script><script src="javascripts/jquery.foundation.tooltips.js"></script><script src="javascripts/jquery.foundation.accordion.js"></script><script src="javascripts/jquery.placeholder.js"></script><script src="javascripts/jquery.foundation.alerts.js"></script><script src="javascripts/jquery.foundation.topbar.js"></script><script src="javascripts/jquery.foundation.joyride.js"></script><script src="javascripts/jquery.foundation.clearing.js"></script><script src="javascripts/jquery.foundation.magellan.js"></script>
  -->
<!-- Included JS Files (Compressed) -->
<script src="../../../../javascripts/jquery.js"></script>
<script src="../../../javascripts/foundation.min.js"></script>

<!-- Initialize JS Plugins -->
<script src="../../../javascripts/app.js"></script>
<script>
	$(window).load(function () {
		$("#featured").orbit();
	});
</script>

	<!-- DISQUS-->
<script type="text/javascript">
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'ratespot'; // required: replace example with your forum shortname

	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function () {
		var s = document.createElement('script'); s.async = true;
		s.type = 'text/javascript';
		s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
		(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	}());
</script>
</body>
</html>
