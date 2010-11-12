<? if($itemsCount): ?>
<div id="Pagination" class="pagination">
        <?
        // ----INPUT PARAMETERS----
        $GLOBALS["itemsCount"] = $itemsCount;
        $GLOBALS["pageLen"] = $pageLen;
        $GLOBALS["updateUrl"] = $updateUrl;
        $GLOBALS["current_page"] = isset($pageNo) ? $pageNo - 1 : 0;
        // ----CONSTANTS----
        $GLOBALS["num_edge_entries"] = isset($numEdgeEntries) ? $numEdgeEntries : 2;
        $GLOBALS["num_display_entries"] = isset($numDisplayEntries) ? $numDisplayEntries : 13;
        $GLOBALS["ellipse_text"] = "...";
        $GLOBALS["prev_show_always"] = true;
        $GLOBALS["next_show_always"] = true;
        $GLOBALS["next_text"] = __('туда');
        $GLOBALS["prev_text"] = __('сюда');

        function numPages() {
            global $itemsCount, $pageLen;
            return ceil($itemsCount / $pageLen);
        }
       
        function getInterval() {
            global $num_display_entries, $current_page;
            $ne_half = ceil($num_display_entries / 2);
            $np = numPages();
            $upper_limit = $np - $num_display_entries;
            $start = $current_page > $ne_half ? max(min($current_page - $ne_half, $upper_limit), 0) : 0;
            $end = $current_page > $ne_half ? min($current_page + $ne_half, $np) : min($num_display_entries, $np);
            return array($start, $end);
        }
        
        function appendItem($page_id, $appendopts=array()) {
            global $updateUrl, $current_page;
            $np = numPages();
            $page_id = $page_id < 0 ? 0 : ($page_id < $np ? $page_id : $np - 1); // Normalize page id to sane value
            if(!isset($appendopts["text"]))
                $appendopts["text"] = $np - $page_id;
            if(!isset($appendopts["classes"]))
                $appendopts["classes"] = "";
            if($page_id == $current_page) {
                echo "<span class='current'>".$appendopts["text"]."</span>";
            } else {
                $tmp = $page_id+1;
                echo "<a href='".$updateUrl.$tmp."' class='".$appendopts["classes"]."'>".$appendopts["text"]."</a>";
            }
        }

        function drawLinks() {
            global $current_page, $num_edge_entries, $num_display_entries, $ellipse_text, $prev_text, $next_text, $prev_show_always, $next_show_always;
            $interval = getInterval();
            $np = numPages();
            // Generate "Previous"-Link
            if($prev_text && ($current_page > 0 || $prev_show_always)) {
                appendItem($current_page-1, array("text" => $prev_text, "classes" => "prev"));
            }
            // Generate starting points
            if ($interval[0] > 0 && $num_edge_entries > 0) {
                $end = min($num_edge_entries, $interval[0]);
                for($i=0; $i<$end; $i++) {
                    appendItem($i);
                }
                if($num_edge_entries < $interval[0] && $ellipse_text) {
                    echo "<span>".$ellipse_text."</span>";
                }
            }
            // Generate interval links
            for($i = $interval[0]; $i < $interval[1]; $i++) {
                appendItem($i);
            }
            // Generate ending points
            if ($interval[1] < $np && $num_edge_entries > 0) {
                if($num_edge_entries < $interval[1] && $ellipse_text) {
                    echo "<span>".$ellipse_text."</span>";
                }
                $begin = max($np - $num_edge_entries, $interval[1]);
                for($i = $begin; $i < $np; $i++) {
                    appendItem($i);
                }
            }
            // Generate "Next"-Link
            if($next_text && ($current_page < $np - 1 || $next_show_always)) {
                appendItem($current_page + 1, array("text" => $next_text, "classes" => "next"));
            }
        }

        drawLinks();
        ?>
</div>
<? endif; ?>