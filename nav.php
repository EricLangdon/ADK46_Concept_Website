<!-- ##############   Main Navigation   ############### -->
    <nav>
        <ol>
            <?php
            print '<li class="';
            if ($path_parts['filename'] == "about") {
                print ' activePage ';
            }
            print '">';
            print '<a href="about.php">About</a>';
            print '</li>';

            //Peaks
            print '<li class="';
            if ($path_parts['filename'] == "peaks") {
                print ' activePage ';
            }
            print '">';
            print '<a href="peaks.php">Peaks</a>';
            print '</li>';

            //History
            print '<li class="';
            if ($path_parts['filename'] == "history") {
                print ' activePage ';
            }
            print '">';
            print '<a href="history.php">History</a>';
            print '</li>';

            //Join
            print '<li class="';
            if ($path_parts['filename'] == "join") {
                print ' activePage ';
            }
            print '">';
            print '<a href="join.php">Join</a>';
            print '</li>';

            //Gallery
            print '<li class="';
            if ($path_parts['filename'] == "gallery") {
                print ' activePage ';
            }
            print '">';
            print '<a href="gallery.php">Gallery</a>';
            print '</li>';

            ?>
        </ol>
    </nav>
