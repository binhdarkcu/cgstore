<?php get_header(); ?>

	<?php
		if( have_posts() ) : the_post();
		$id = get_the_ID();
		$post_author_id = get_post_field( 'post_author', $id);
		$permalink = get_the_permalink($id);

		?>
	<div class="content-area site-page--gallery">
	  	<section class="content-section blog-post">
			<div class="container">
				
				<div class="gallery">
					<div class="gallery__main">
						<h3 class="gallery__title"><?php echo get_the_title($id); ?></h3>
						<div class="gallery__header">
							<?php 
							$i=0;
							$type_galleries = get_the_terms($id, 'category_gallery' );
							 if($type_galleries):
							?>
							<div class="gallery__info">Posted in 
								<?php foreach ($type_galleries as $type_gallery): $i++;?>
									<a href="<?php echo get_category_link($type_gallery->term_id);?>"><?php echo $type_gallery->name;?></a> <?php if($i < count($type_galleries)) echo ',';?>
								<?php endforeach;?>
								<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';?>
							 	<div class="gallery__author">by 
								<div class="avatar avatar--small">
									<a href="<?php echo bp_loggedin_user_domain(); ?>"> <?php bp_loggedin_user_avatar( 'type=thumb&width=30&height=30' );?></a>
									</div>
									<a href="<?php echo bp_loggedin_user_domain(); ?>"><?php the_author_meta( 'user_nicename', $post_author_id ) ?></a>
								</div>
							</div>
						<?php endif; ?>
							<div class="clear"></div>
						</div>
						<div class="box gallery__images">
							<div class="l-inner-compact">
								<?php
	                                  the_content();
								 ?>
							</div>
						</div>
						<div class="gallery__description"><?php echo get_the_excerpt();?></div>
						<div class="tag-list">
							<span>Tags:</span>
							<ul>
							<?php
								echo get_the_term_list($id,'gallery_tag','<li>','','</li>');
							?>
							</ul>
						</div>
						<div class="yourcomment">
							<h3 class="content-heading__title">Comments</h3>
							<?php
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>
						</div>
					</div>
					<div class="gallery__sidebar">
						<div class="gallery__like">
							<?php 
				                  $liked = ''; 
				                  $onclick = 'ats_load_form();'; 
				                  $id= get_the_ID();
				                  $total_like = get_post_meta($id,PREFIX_WEBSITE.'total_like',true);
				                 if(is_user_logged_in()): 
				                  $key = wp_create_nonce('cgs-security-like');  
				                  $current_user = wp_get_current_user();
				                  $likes  = get_user_meta($current_user->ID,PREFIX_WEBSITE.'likes',true);
				                  if(!is_array($likes)) $likes = (array) $likes;
				                  if(in_array($id,(array)$likes)) :
				                      $liked = 'liked'; 
				                      $key = wp_create_nonce('cgs-security-unlike'); 
				                      $onclick ='cgs_on_unlike(\''.$key.'\',\''.$id.'\',this)';
				                   else: 
				                     $onclick ='cgs_on_like(\''.$key.'\',\''.$id.'\',this)';
				                    endif;

				                 endif;
					        ?>
							<div class="like-button js-auth-control js-like" data-item-id="8436" data-item-type="Gallery">
								<div class="like-button__text <?php echo $liked; ?>" onclick="<?php echo $onclick; ?>">Like this</div>
								<div class="like-button__counter"><span class="total-like"><?php echo ($total_like) ? $total_like : 0 ; ?></span></div>
							</div>
						</div>
						<div class="card">
						   <div class="card__content">
						      <ul class="list list--inline gallery__stats">
						         <li><img alt="Views" class="js-tooltip tooltipstered" width="30" height="30" src="<?php echo TEMPLATE_PATH ?>/images/eye.png"> <span><?php echo the_views(); ?></span></li>
						         <li><img alt="Likes" class="js-tooltip tooltipstered" width="30" height="30" src="<?php echo TEMPLATE_PATH ?>/images/heart.png"> <span class="total-like"><?php echo ($total_like) ? $total_like : 0 ; ?></span></li>
						         <li><img alt="Comments" class="js-tooltip tooltipstered" width="30" height="30" src="<?php echo TEMPLATE_PATH ?>/images/conversation.png"> <span><?php echo get_comments_number();?></span></li>
						      </ul>
						   </div>
						</div>
						<div class="card">
						   <div class="card__content">
						      <div class="details-box-title">Share gallery</div>
						        <div class="product-share-old">
						            <ul class="list list-inline u-text-center social-networks">
						                <li class="list-item">
						                    <a class="social-icon facebook" href="https://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" target="_blank">
						                        <span class="fa-stack fa-social-share fa-facebook-icon"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-inverse fa-stack-1x"></i></span>
						                    </a>
						                </li>
						                <li class="list-item">
						                    <a class="social-icon linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink ?>&title=<?php echo $post_title ?>&summary=<?php echo $post->post_excerpt ?>" target="_blank">
						                        <span class="fa-stack fa-social-share fa-linkedin-icon"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-linkedin fa-inverse fa-stack-1x"></i></span>
						                    </a>
						                </li>
						                <li class="list-item">
						                    <a class="social-icon twitter" href="https://twitter.com/share?url=<?php echo $permalink; ?>" target="_blank">
						                        <span class="fa-stack fa-social-share fa-twitter-icon"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-inverse fa-stack-1x"></i></span>
						                    </a>
						                </li>
						                <li class="list-item">
						                    <a class="social-icon google-plus" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" target="_blank">
						                        <span class="fa-stack fa-social-share fa-google-plus-icon"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-inverse fa-stack-1x"></i></span>
						                    </a>
						                </li>
						                <li class="list-item is-last">
						                    <a class="social-icon pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&amp;media=<?php echo $featured_image_2; ?>&amp;description=<?php echo $post_title; ?>" target="_blank">
						                        <span class="fa-stack fa-social-share fa-pinterest-icon"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-pinterest fa-inverse fa-stack-1x"></i></span>
						                    </a>
						                </li>
						            </ul>
						        </div>
						  </div>
						</div>
						<div class="card">
						   <div class="card__content">
						      <h4 class="card__heading">More by <?php the_author_meta( 'user_nicename', $post_author_id ) ?></h4>
						      <div class="card__wrapper">
						         <ul class="galleries">
						         	<?php
						         		$args = array(
										    'author'        =>  $post_author_id,
										    'post_type' 	=>  'gallery',
										    'posts_per_page' => 4
									    );
									    $current_posts = get_posts($args);
									    foreach ( $current_posts as $g_current ) : setup_postdata( $g_current ); ?>
											<li><a class="js-tooltip tooltipstered" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($g_current->ID)?></a></li>
										<?php endforeach; 
						         	?>
						            
						         </ul>
						         <div class="u-text-right"><a href="<?php echo HOME_URL?>/gallery/?userid=<?php echo $post_author_id;?>">More user projects <i class="fa fa-chevron-right"></i> </a></div>
						      </div>
						   </div>
						</div>
					</div>
				</div>
			</div>
		</section>

	  </div>
	<?php
		endif; // End of the loop.
	?>


<?php
get_footer();