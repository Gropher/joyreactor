<?php
    function createGuid() {
        $guid = "";
        // This was 16 before, which produced a string twice as
        // long as desired. I could change the schema instead
        // to accommodate a validation code twice as big, but
        // that is completely unnecessary and would break
        // the code of anyone upgrading from the 1.0 version.
        // Ridiculously unpasteable validation URLs are a
        // pet peeve of mine anyway.
        for ($i = 0; ($i < 8); $i++) {
            $guid .= sprintf("%02x", mt_rand(0, 255));
        }
        return $guid;
    }

?>
