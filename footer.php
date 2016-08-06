	<footer id="footer">
		<i class="fa fa-copyright"></i>
<?php
$fromYear = 2012;
$thisYear = (int) date('Y');
echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');
?> , James Van Waza
	</footer>
	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script src="js/flexnav.js"></script>
	<script src="js/datatables.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
