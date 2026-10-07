<?php

use Illuminate\Support\HtmlString;

if (! function_exists('rich')) {
    /**
     * Escape text, then turn *words* into italic serif highlights.
     * Lets editors add emphasis from the admin without writing HTML.
     */
    function rich(?string $text): HtmlString
    {
        $escaped = e((string) $text);

        return new HtmlString(preg_replace('/\*(.+?)\*/u', '<em class="accent">$1</em>', $escaped));
    }
}
