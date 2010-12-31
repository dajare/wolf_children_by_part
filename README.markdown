## INTRODUCTION

![Wolf logo](http://www.wolfcms.org/wiki/_media/wolf_logo_64.png "Wolf CMS logo")
This is a plugin for [Wolf CMS][l00]. It provides the functionality to return child pages sorted by a specified page-part's content.

It was authored by [Christian Schorn][l01] and was discussed in the [Frog forum][l02]. It has now been ported to Wolf CMS.

[l00]: http://www.wolfcms.org/ "Wolf CMS"
[l01]: http://christian-schorn.de/ "Christian Schorn"
[l02]: http://bit.ly/kCnRR "Frog forum thread"

* First (frog) release: 2008.10.12
* First (wolf) release: 2009.08.13

## USAGE NOTES

### Installation:

1. Place this plugin (as a directory named 'children_by_part' with all contents) in the Wolf /wolf/plugins directory.
2. Activate the plugin through the administration screen.

### Usage:

`children_by_part([parent-page], [page-part name], [order], [#])` :

*  [parent-page] = the URI/identity of the page the children of which will be sorted:  
examples: $this, find_page_by_uri('/slug/')
*  [page-part name] = the name of the page-part (not "body"!) to be sorted
*  [order] = can be ASC or DESC
*  [#] = the number of pages to be returned

## EXAMPLE

The page called "Events" (slug = events) has a number of child pages, each with a page part called "date". The following code, used on the "Events" page, will give a date-ordered listing of the child pages, with a link to the sub-page:

    <h3>Event Dates</h3>
    
    <?php foreach (children_by_part($this,'date') as $event): ?>
    <h4><?php echo $event->link(),',&nbsp;',$event->content('date'); ?></h4>
    <hr />
    <?php endforeach ?>

All child pages which have the 'date' page-part will be returned, in date order. Those without the 'date' page-part will be ignored.
