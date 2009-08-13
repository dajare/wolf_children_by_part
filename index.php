<?php
/**
 * cs_children_by_part
 */

Plugin::setInfos(array(
  'id'          => 'children_by_part',
  'title'       => 'Children by part',
  'description' => 'Provides a function to get children of a page ordered by the contents of a page-part',
  'version'     => '0.1',
  'author'      => 'Christian Schorn; ported by David Reimer',
  'require_wolf_version' => '0.5.5'
));

/**
 * History:
 * ported to Wolf CMS 2009-08-13
 */

/**
 * Gets the direct descendants of a page ordered by the contents of one of their parts.
 *
 * @param object the page
 * @param string the name of the part
 * @param string how to sort the results. Valid values are 'asc' or 'desc'
 * @param int how many results are to be returned
 * @param int the offset 
 */
 
function cs_children_by_part(&$page, $part_name, $order = 'asc', $limit = 0, $offset = 0)
{
  global $__CMS_CONN__;
  
  $order_sql = strtolower($order) == 'desc' ? 'desc' : 'asc';
  
  $limit  = (int) $limit;
  $offset = (int) $offset;
  if ($limit > 0) {
    $limit_sql = "limit $offset, $limit";
  } else {
    $limit_sql = '';
  }
  
  $sql = "select pg.slug
          from ".TABLE_PREFIX."page as pg
          left join ".TABLE_PREFIX."page_part as pg_part on pg_part.page_id = pg.id
          where
          pg.parent_id = ?
          and pg_part.name = ?
          order by pg_part.content $order_sql
          $limit_sql";
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