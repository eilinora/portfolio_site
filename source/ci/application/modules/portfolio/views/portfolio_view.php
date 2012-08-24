<div class="portfolio-table">
	<?php  
		for ($i = 0; $i < 10; $i++) {
			$itemID = "item_".$i;
	?>
	<div id="<?=$itemID?>" class="portfolio-item clearfix">
		<div class="miniContainer">
			<div class="portfolio-image"><img src="/media/images/portfolio/BL_LandingPage_300x195.jpg" width="260" /></div>
			<div class="portfolio-info">
				<h1 class="portfolio-title"><span class="portfolio-title header-font">Big Love Land</span></h1>
				<h2 class="portfolio-company"><span class="portfolio-company header-font">client:</span> Deep Focus</h2>
				<h3 class="portfolio-role"><span class="portfolio-role header-font">role:</span> Architect and Programmer</h3>
			</div>
			<div class="portfolio-blurb">Programmed in Actionscript 2.0 and Flash 8. Program uses XML to run different board game scenarios as well as to load information about each of the board pieces...</div>
			
			<div class="portfolio-bottom">
				<div class="view"><a href="">view</a></div>
				<div class="read-more"><a href="javascript:expandItem('<?=$itemID?>');">read more >></a></div>
			</div>
		</div>
	</div>
	<?php 
		}
	?>
</div>