<?php

defined('_JEXEC') or die;

JHtml::stylesheet('mod_ntb_newsmatrix/template.css', array(), true); 

?>
<ul class="ntb_newsmatrix_divcols<?= $matrix_cols ?><?= $class_sfx ?> ntb_newsmatrix_ul<?= $class_sfx ?>">
<?php foreach ($matrix as $block ) : ?>
	<li>
		<h3 class="ntb_newsmatrixHeading<?= $class_sfx ?>">
			<a href="<?= $block['link'] ?>" rel="nofollow"><?= $block['name'] ?></a>
		</h3>
		<ul class="ntb_newsmatrixLists<?= $class_sfx ?>">
		<?php foreach ($block['article'] as $article) : ?>
			<li>
				<a href="<?= $article['link'] ?>"><?= $article['title'] ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
	</li>
<?php endforeach; ?>
</ul>