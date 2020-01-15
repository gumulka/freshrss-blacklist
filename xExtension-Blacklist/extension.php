<?php

/**
 * Class BlacklistExtension
 *
 * Latest version can be found at https://github.com/gumulka/freshrss-blacklist
 *
 * @author Fabian Pflug
 */
class BlacklistExtension extends Minz_Extension
{
    /**
     * Initialize this extension
     */
    public function init() {
        $this->registerHook('entry_before_insert', array($this, 'markRead'));
    }

    /**
     * Mark the entry as read if one of the blacklisted words can be fount in the title
     *
     * @param FreshRSS_Entry $entry
     * @return mixed
     */
    public function markRead($entry) {
        $pos = strpos($entry->title(), "heise+ |");
        if($pos == 0) {
            $entry->_isRead(TRUE);
        }
        return $entry;
    }
}
