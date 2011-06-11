## Introduction

![Wolf logo](http://www.wolfcms.org/wiki/_media/wolf_logo_64.png "Wolf CMS logo")
This is a plugin for [Wolf CMS][l00]. It provides the functionality to return child pages sorted by a specified page-part's content.

It was authored by [Christian Schorn][l01] and was discussed in the [Frog forum][l02]. It has now been ported to Wolf CMS.

[l00]: http://www.wolfcms.org/ "Wolf CMS"
[l01]: http://christian-schorn.de/ "Christian Schorn"
[l02]: http://bit.ly/kCnRR "Frog forum thread"

## Usage Notes

### Installation:

1. Place this plugin (ensuring the directory is named 'children_by_part', with all contents) in the Wolf /wolf/plugins directory.
2. Activate the plugin through the administration screen.

### Usage:

`children_by_part([parent-page], [page-part name], [order], [limit], [offset])` :

*  [parent-page] = the URI/identity of the page the children of which will be sorted:  
examples: `$this`, `$this->find('slug')`, `Page::findById(21)`
*  [page-part name] = the name of the page-part (not "body"!) to be sorted
*  [order] = can be ASC or DESC for alpha sort, ASCNUM or DESCNUM for numeric sort
*  [limit] = the number of pages to be returned (integer)
*  [offset] = an offset, to begin sort at nth child (integer)

Only the **parent-page** and the **page-part name** are required.

## Example

The page called "Events" (slug = events) has a number of child pages, each with a page part called "date", where you put a date like "2011-02-14". The following code, used on the "Events" page, will then give a date-ordered listing of the child pages, with a link to the sub-page:

    <h3>Event Dates</h3>
    
    <?php foreach (children_by_part($this,'date') as $event): ?>
    <h4><?php echo $event->link(),',&nbsp;',$event->content('date'); ?></h4>
    <hr />
    <?php endforeach; ?>

* All child pages which have the 'date' page-part will be returned, in date order.
* Those **without** the 'date' page-part will be **ignored**.

## Changelog

0.4

* 2011-06-11 : new location for version XML file
* 2011-02-12 : update plugin info, i18n for id etc.

0.3

* 2011-02-12 : numeric sort option added; doc update and tidy

0.2

* 2011-01-26 : function name correction; doc update

0.1

* 2009-08-13 : First Wolf release
* 2008-10-12 : First Frog release
