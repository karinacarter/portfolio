<?php

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once JPATH_SITE . '/components/com_ntb_tags/models/topic.php';

jimport('ntb.tags.cache');

/**
 * Class modNTB_NewsMatrixHelper
 *
 * @since 2.5
 */
class modNTB_NewsMatrixHelper {
	
	/**
	 * @param   \Joomla\Registry\Registry $params Module parameters.
	 *
	 * @return mixed|stdClass
	 * @throws \Exception
	 * @throws \RuntimeException
	 *
	 * @since 2.5
	 */
	public static function getMatrix(&$params) {
		
		$nav_cluster    = $params->get('nav_cluster', 0);
		$nav_tags       = (array) $params->get('nav_tag', 0);
		$topic_clusters = (array) $params->get('topic_cluster', 0);
		$enable_cache   = $params->get('enable_cache', 'yes');
		$cache_time     = $params->get('cache_time', 900);
		$cols           = (int) $params->get('cols', 3);
		$count          = (int) $params->get('count', 5);
		$enable_shuffle = (int) $params->get('enable_shuffle', true);
		
		$nav_tags = preg_replace("#^$nav_cluster:(\d+)$#", '$1', $nav_tags);
		
		$cache_key = implode(':', [ $nav_cluster, implode('-', $nav_tags), implode('-', $topic_clusters), $cols, $count ]);
		
		if ($enable_cache != 'no') {
			
			$cache = JFactory::getCache('mod_ntb_newsmatrix', '');
			$cache->setLifeTime($cache_time);
			if ($enable_cache == 'yes') {
				$cache->setCaching($enable_cache);
			}
			$matrix = $cache->get($cache_key);
		} else {
			
			$matrix = null;
		}
		
		if (empty($matrix)) {
			
			$matrix = [];
			
			foreach ($nav_tags as $nav_tag) {
				
				$key = implode('-', [ 0, 0, $nav_cluster, $nav_tag ]);
				
				$articles = NTB_TagsModelTopic::getStaticItems(0, 0, $nav_cluster, $nav_tag, 'created', 0, $count);
				
				if (count($articles) == 0) {
					continue;
				}
				
				$matrix[$key]['name'] = NTBTags::getTagName($nav_tag);
				
				$menu = NTBTags::getTopicMenu(0, 0, $nav_cluster, $nav_tag);
				if (is_object($menu)) {
					$matrix[$key]['link'] = $menu->alias;
				} else {
					$matrix[$key]['link'] = JRoute::_(NTBTags::getTopicNavLink(0, 0, $nav_cluster, $nav_tag));
				}
				
				foreach ($articles as $a) {
					
					$link = "index.php?option=com_content&view=article&id={$a->id}&catid={$a->catid}";
					if (is_object($menu)) {
						$link .= "&Itemid={$menu->id}";
					}
					
					$matrix[$key]['article'][$a->id]          = [];
					$matrix[$key]['article'][$a->id]['link']  = JRoute::_($link);
					$matrix[$key]['article'][$a->id]['title'] = $a->title;
				}
			}
			
			foreach ($topic_clusters as $topic_cluster) {
				
				$key = implode('-', [ $topic_cluster, 0, $nav_cluster, 0 ]);
				
				$articles =
					NTB_TagsModelTopic::getStaticItems($topic_cluster, 0, $nav_cluster, 0, 'created', 0, $count);
				
				if (count($articles) == 0) {
					continue;
				}
				
				$matrix[$key]['name'] = NTBTags::getClusterName($topic_cluster);
				
				$menu = NTBTags::getTopicMenu($topic_cluster, 0, $nav_cluster, 0);
				if (is_object($menu)) {
					$matrix[$key]['link'] = $menu->alias;
				} else {
					$matrix[$key]['link'] = JRoute::_(NTBTags::getTopicNavLink($topic_cluster, 0, $nav_cluster, 0));
				}
				
				foreach ($articles as $a) {
					
					$link = "index.php?option=com_content&view=article&id={$a->id}&catid={$a->catid}";
					if (is_object($menu)) {
						$link .= "&Itemid={$menu->id}";
					}
					
					$matrix[$key]['article'][$a->id]          = [];
					$matrix[$key]['article'][$a->id]['link']  = JRoute::_($link);
					$matrix[$key]['article'][$a->id]['title'] = $a->title;
				}
			}
			
			if ($enable_cache) {
				$cache->store($matrix, $cache_key);
			}
		}
		
		if ($enable_shuffle) {
			shuffle($matrix);
		}
		
		return $matrix;
	}
}