<?php
/**
 *
 * Template Name: Event Page, Table
 *
 * A template for displaying a page with an event table.
 *
 * @package WordPress
 * @subpackage bv-golf
 */
get_header();

?> 

<div id="primary" class="site-content container">
    <div id="content" role="main">
        <?php 
	while ( have_posts() ) : the_post();
        ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    
                    the_content();

                    // WP_Query arguments
                    $args = array(
                        'post_type' => 'am_event',
                        'post_status' => 'publish',
                        'orderby' => 'meta_value',
                        'meta_key' => 'am_startdate',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'am_enddate',
                            'value' => date('Y-m-d H:i:s', time()), //don't change date format here!
                            'compare' => ">",
                            ),
                        ),
                    );
                    $the_query = new WP_Query($args);

                    // Display the page content and
                    ?>

                    <?php // Display the event table ?>
                    <table id="events-table" class="table" border="1">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Date</th>
                                <!--<th>Category</th>-->
                                <th>Venue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The Loop
                            if ($the_query->have_posts()) {
                                while ($the_query->have_posts()) {
                                    $the_query->the_post();
                                    $postLink = get_permalink( $post->ID );
                                    $postId = $post->ID;

                                    echo '<tr>';

                                    echo '<td>';
                                    am_the_startdate ('<p>d</p>', '<a href="' . $postLink . '"><i class="fa fa-calendar-o" aria-hidden="true"></i></a>');

                                    //echo '<p class="text-center"><i class="fa fa-calendar-o" aria-hidden="true"></i></p>';

                                    the_title('<td><h4><a href="' . $postLink . '">', '</a></h4></td>');

                                    echo "</td>";
                                    am_the_startdate('Y-m-d H:i', '<td>', '');
                                    am_the_enddate('Y-m-d H:i', ' - ', '</td>');

                                    //echo '<td>' . am_get_the_event_category_list(',', 'multiple') . '</td>';

                                    echo '<td>' . am_get_the_venue_list(',', 'multiple') . '</td>';

                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>

                </div><!-- .entry-content -->

                <footer class="entry-meta">
                        <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-meta -->

            </article><!-- #post -->
            
            <?php comments_template( '', true ); ?>
            
        <?php endwhile; // end of the loop. ?>
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>