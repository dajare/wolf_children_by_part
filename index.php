<?php
/**
 * children_by_part
 */

Plugin::setInfos(array(
  'id'          => 'children_by_part',
  'title'       => __('Children by part'),
  'description' => __('Provides a function to return the children of a page ordered by the contents of a page-part'),
  'version'     => '0.4',
  'website'     => 'https://github.com/dajare/wolf_children_by_part',
  'author'      => 'Christian Schorn; updated by David Reimer',
  'update_url'  => 'http://subversion.assembla.com/svn/wolf_tools/trunk/xml/plugin_versions.xml',
  'require_wolf_version' => '0.5.5'
));

/**
 * Gets the direct descendants of a page ordered by the contents of one of their parts.
 *
 * @param object the parent page
 * @param string the name of the page-part in child pages for sorting
 * @param string OPTIONAL how to sort the results; valid values: 'ASC'/'DESC' for alpha sort; 'ASCNUM'/'DESCNUM' for numeric sort; default = 'ASC'
 * @param int OPTIONAL how many results are to be returned
 * @param int OPTIONAL the offset 
 */
 
function children_by_part(&$page, $part_name, $order = 'asc', $limit = 0, $offset = 0)
{
  global $__CMS_CONN__;
  
  $order = strtolower($order);
  
  switch ($order) {
    case 'asc';
	  $order_sql = 'asc';
	  break;
    case 'desc';
	  $order_sql = 'desc';
	  break;
    case 'ascnum';
	  $order_sql = 'asc';
	  break;
    case 'descnum';
	  $order_sql = 'desc';
	  break;
    default:
	  $order_sql = 'asc';
  }
  
  $limit  = (int) $limit;
  $offset = (int) $offset;
  if ($limit > 0) {
    $limit_sql = "limit $offset, $limit";
  } else {
    $limit_sql = '';
  }
  
  if ($order == 'asc' || $order == 'desc' ) {
  $sql = "select pg.slug
          from ".TABLE_PREFIX."page as pg
          left join ".TABLE_PREFIX."page_part as pg_part on pg_part.page_id = pg.id
          where
          pg.parent_id = ?
          and pg_part.name = ?
          order by pg_part.content $order_sql
          $limit_sql";
  } else {
  $sql = "select pg.slug
          from ".TABLE_PREFIX."page as pg
          left join ".TABLE_PREFIX."page_part as pg_part on pg_part.page_id = pg.id
          where
          pg.parent_id = ?
          and pg_part.name = ?
          order by abs(pg_part.content) $order_sql
          $limit_sql";
  }

  $sth = $__CMS_CONN__->prepare($sql);
  $sth->execute(array($page->id(), $part_name));
  
  $children = array();
  
  while ($slug = $sth->fetchColumn()) {
    $p = find_page_by_slug($slug, $page);
    if ($p) {
      $children[] = $p;
    }
  }
  
  return $children;
}
