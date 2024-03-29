<?php require "core.php"; ?>
<?php header('Content-type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php $getPages = getPages($connect); ?>
<?php foreach($getPages as $item): ?>
<url>
<loc><?php echo $urlPath->page($item['page_slug']); ?></loc>
</url>
<?php endforeach; ?>

<?php $getDeals = getDeals($connect); ?>
<?php foreach($getDeals as $item): ?>
<url>
<loc><?php echo $urlPath->deal($item['deal_id'], $item['deal_slug']); ?></loc>
<lastmod><?php echo formatDate($item['deal_updated']); ?></lastmod>
</url>
<?php endforeach; ?>

<?php $getStores = getStores($connect); ?>
<?php foreach($getStores as $item): ?>
<url>
<loc><?php echo $urlPath->search(['store' => $item['store_slug']]); ?></loc>
</url>
<?php endforeach; ?>

<?php $getLocations = getLocations($connect); ?>
<?php foreach($getLocations as $item): ?>
<url>
<loc><?php echo $urlPath->search(['location' => $item['location_slug']]); ?></loc>
</url>
<?php endforeach; ?>

<?php $getCategories = getCategories($connect); ?>
<?php foreach($getCategories as $item): ?>
<url>
<loc><?php echo $urlPath->search(['category' => $item['category_slug']]); ?></loc>
</url>
<?php endforeach; ?>

<?php $getSubCategories = getSubCategoriesSiteMap($connect); ?>
<?php foreach($getSubCategories as $item): ?>
<url>
<loc><?php echo $urlPath->search(['subcategory' => $item['subcategory_slug']]); ?></loc>
</url>
<?php endforeach; ?>

</urlset>
