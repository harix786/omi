<?php
/*
 * This function receives a search term, calls the intern search api, and prints
 * the results in a list.
 */

require '../includes/config/config.php';

$searchString = $_GET['s'];

$title = preg_replace("/ /", '+', $searchString);

$searchApiPath = $path . 'search/api/search.php';
$searchUrl = 'http://localhost' . $searchApiPath . '?s=' . $title;

//HTTP request to OMDb API with JSON answer
$json = file_get_contents($searchUrl);

//JSON decode of answer
$data = json_decode($json, true);
?>
<small id="localSearchIntro">Local results:</small><br>
<div id="SearchResults">
	<?php
	foreach ($data as $result)
	{
		foreach ($result as $movie)
		{
			?>
			<div class="col-lg-12">
				<?php
				$title = $movie['Title'];
				$year = $movie['Year'];
				if ($year == null)
				{
					$year = "N/A";
				}
				$imdbId = $movie['imdbID'];
				$type = $movie['Type'];
				?>
				<h4 class="movie-title-search-link movie-title" id="<?php echo $imdbId ?>">
					<?php echo $title ?> (<?php echo $year ?>) 
					<a href="http://www.imdb.com/title/<?php echo $imdbId ?>/" target="_blank">
						<img src="http://ia.media-imdb.com/images/G/01/imdb/images/plugins/imdb_46x22-2264473254._CB379390954_.png">
					</a>
				</h4>
			</div>
			<?php
		}
	}
	?>
</div>
<div class="clearfix"></div>
<script async>
	$(document).ready(function () {
		$(".movie-title").click(function () {
			var selection = $(this).attr('id');
			$.get('<?php echo $path ?>search/movieSelectView.php', {i: selection}, function (respons) {
				$('#movieListingArea1').html(respons);
			});
		});
	});
</script>