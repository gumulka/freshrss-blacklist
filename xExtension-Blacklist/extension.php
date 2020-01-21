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
        foreach(FreshRSS_Context::$user_conf->blacklist_words as $blword) {
            $pos = strpos($entry->title(), $blword);
            if($pos === false) {} else {
                $entry->_isRead(TRUE);
            }
        }
        return $entry;
    }

    /**
     * Configure this extension with words and safe them to an array.
     */
    public function handleConfigureAction() {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            $blacklist = html_entity_decode(Minz_Request::param('blacklist', ''));
            FreshRSS_Context::$user_conf->blacklist_words = preg_split("/((\r?\n)|(\r\n?))/", $blacklist);
            FreshRSS_Context::$user_conf->save();
        }

        $this->words = '';
        if (FreshRSS_Context::$user_conf->blacklist_words != '') {
            $this->words = implode("\n", FreshRSS_Context::$user_conf->blacklist_words);
        }
    }
}
?>
