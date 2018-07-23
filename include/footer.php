           <!-- FIN du contenu -->
 <!-- PIED DE PAGE -->
  <div id="footer"><p>
<?php
	//on affiche le menu
	echo '<a href="conditions.php" title="Découvrez nos conditions générales"';
	if ($menu == 'm7')
		echo ' class="selection"';
	echo '>Conditions</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="menlegal.php" title="Mentions légales de RESTOnet"';
	if ($menu == 'm10')
		echo ' class="selection"';
	echo '>Mentions légales</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="contact.php" title="Comment contacter RESTOnet"';
    if ($menu == 'm4')
		echo ' class="selection"';
	echo '>Contact</a>&nbsp;&nbsp;|&nbsp;&nbsp;
   <a href="http://www.iiidees.com/fr/" title="Visiter le site de notre webmaster" target="_blank">&copy; 2012 www.iiidees.com</a>';
?>
   </p>
  </div>
  <div style="clear:both"></div>
</div>
</body>
</html>
