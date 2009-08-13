<?php
/**
 * cs_children_by_page
 */

Plugin::setInfos(array(
  'id'          => 'cs_children_by_part',
  'title'       => 'Children by part',
  'description' => 'Provides a function to get children of a page ordered by the contents of a part',
  'version'     => '0.1a',
  'author'      => 'Christian Schorn',
));

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
  global $__FROG_CONN__;
  
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
  $sth = $__FROG_CONN__->prepare($sql);
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