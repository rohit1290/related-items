<?php
$page = elgg_extract('guid', $vars);
$entity = get_entity($page);
if ($entity instanceof ElggObject) {
	$subtype = $entity->getSubtype();
	$container = $entity->getContainerEntity();
	$group = $entity->getContainerEntity();
	switch ($subtype) {
		case 'image':
		{
			elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
			elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
			$subtype = 'photos';
			$group = get_entity($container->container_guid);
			break;
		}
		case 'page_top':
		{
			elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');
			$subtype = 'pages';
			break;
		}
		case 'videolist_item':
		{
			elgg_push_breadcrumb(elgg_echo('videolist'), 'videolist/all');
			$subtype = 'videolist';
			break;
		}
		case 'bookmarks':
		{
			elgg_push_breadcrumb(elgg_echo('bookmarks'), 'bookmarks/all');
			break;
		}
		case 'file':
		{
			elgg_push_breadcrumb(elgg_echo('file'), 'file/all');
			break;
		}
		case 'blog':
		{
			elgg_push_breadcrumb(elgg_echo('blog'), 'blog/all');
			break;
		}
		case 'au_set':
		{
			elgg_push_breadcrumb(elgg_echo('au_set'), 'pinboards/all');
			break;
		}
		default:
		break;
	}

	if ($group instanceof ElggGroup) { //container
		elgg_push_breadcrumb($group->name, $subtype . "/group/$group->guid");
	} else {
		$owner = $entity->getOwnerEntity();
		elgg_push_breadcrumb($owner->name,  $subtype . "/owner/$owner->username");
	}
	if ($subtype === 'photos') { // album
		elgg_push_breadcrumb($container->getTitle(), $container->getURL());
	}

	elgg_push_breadcrumb(elgg_get_excerpt($entity->title, 75), $entity->getURL()); // item
   // elgg_push_breadcrumb(elgg_echo('related-items:title'));
	$offset = (integer) max(get_input('offset', 0), 0);
	$limit = 10;
	$entity_list = get_related_entities($entity, $limit, false, $offset);

	if ($entity_list) {
		$title = elgg_echo('related-items:title');
		$content = elgg_view_entity_list($entity_list, [
			'count' => get_related_entities($entity, 0, true, 0),
			'offset' => $offset,
			'limit' => $limit,
			'full_view' => false,
			'list_type_toggle' => false,
			'pagination' => true]);
	} else {
		$title = elgg_echo('related-items:title');
		$content = elgg_echo('related-items:none');
	}

	$layout = elgg_view_layout('default', [
		'title' => $title,
		'content' => $content,
		'filter' => false,
	]);

	echo elgg_view_page($title, $layout);
}

	