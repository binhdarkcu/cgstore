<?php
/**
 * BuddyPress - Members Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_home_content' ); ?>

	<div id="item-header" role="complementary">

		<?php
		/**
		 * If the cover image feature is enabled, use a specific header
		 */
		if ( bp_displayed_user_use_cover_image_header() ) :
			bp_get_template_part( 'members/single/cover-image-header' );
		else :
			bp_get_template_part( 'members/single/member-header' );
		endif;
		?>

	</div><!-- #item-header -->
    <?php
       $profile_ID = bp_displayed_user_id();
       $userID   = get_current_user_id();
       $d_model  = cgs_count_product_by_user($profile_ID,D3_MODEL,'product_cat');
       $vr_model = cgs_count_product_by_user($profile_ID,VR_MODEL,'product_cat');
       $gallery = cgs_count_product_by_user($profile_ID,null,null,'gallery');
       $free = cgs_count_product_by_user($profile_ID,null,null,'product',true);
       if(bp_is_user_activity()):  
	 ?>
	<div class="user-content">
		<div class="user-content__tabs" data-easytabs="true">
		   <ul class="tabs tabs--sealed">
		   <?php if($d_model->found_posts > 0 ):  ?>
		      <li class="tabs__item is-active" data-count="128"><a href="#tab-low_poly" class="is-active">VR / Low-Poly models (<?php echo isset($d_model->found_posts) ? $d_model->found_posts : 0; ?>)</a></li>
		  <?php  endif; ?>
		  <?php if($vr_model->found_posts > 0 ):  ?>
		      <li class="tabs__item" data-count="7340"><a href="#tab-cg">3D Models (<?php echo isset($vr_model->found_posts) ? $vr_model->found_posts : 0; ?>)</a></li>
		   <?php endif; ?>
		   <?php if($free->found_posts > 0 ):  ?>
		      <li class="tabs__item" data-count="4"><a href="#tab-free">Free 3D Models (<?php echo isset($free->found_posts) ? $free->found_posts : 0; ?>)</a></li>
		    <?php endif; ?>
		    <?php if($gallery->found_posts > 0 ):  ?>
		      <li class="tabs__item" data-count="1"><a href="#tab-galleries">Gallery (<?php echo isset($gallery->found_posts) ? $gallery->found_posts : 0; ?>)</a></li>
		     <?php endif; ?>
		   </ul>
		</div>
		<div class="user-content__content">
			<div class="tab-content is-active" id="tab-low_poly">
				<div class="content-box-wrapper grid">
					<?php
		                echo do_shortcode('[custom_category_products category="3d-models" per_page="12" columns="4" author="'.$profile_ID.'"]');
					  ?>
				</div>
			</div>
			<div class="tab-content " id="tab-cg">
				<div class="content-box-wrapper grid">
					<?php
		                echo do_shortcode('[custom_category_products category="vr-low-poly-models" per_page="12" columns="4" author="'.$profile_ID.'"]');
					  ?>
				</div>
			</div>
			<div class="tab-content " id="tab-free">
				<div class="content-box-wrapper grid">
					<?php
		                echo do_shortcode('[custom_category_products per_page="12" columns="4" author="'.$profile_ID.'" free="1"]');
					  ?>
				</div>
			</div>
			<div class="tab-content " id="tab-galleries">
				<div class="content-box-wrapper grid">
					<?php 

					    query_posts(array('post_type'=>'gallery','posts_per_page'=>12,'author'=>$profile_ID,'post_status' => 'publish'));
					    if(have_posts()){
					          
					 ?>
					<div class="showcase-items">
						 <?php  while( have_posts()) {
			   	               the_post();
			           ?>
						<article class="showcase-item">
							<div class="showcase-item-content">
								<header class="showcase-item-header">
									<h1 class="showcase-item-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h1>
									<div class="showcase-item-info">
										<?php
											$liked = ''; 
							                  $onclick = 'ats_load_form();'; 
							                  $id = get_the_ID();
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
										<div class="showcase-item-stats"><i class="fa fa-heart-o"></i><?php echo ($total_like) ? $total_like : 0 ; ?></div>
										<div class="showcase-item-author">
											<a href="<?php echo bp_loggedin_user_domain(); ?>"> <?php bp_loggedin_user_avatar( 'type=thumb&width=26&height=26' );?></a>
											<a href="<?php echo get_the_author_link(the_ID());?>"><?php echo get_the_author_meta('display_name') ;?></a>
										</div>
									</div>
								</header>
								<div class="showcase-item-image">
									<?php if ( has_post_thumbnail() ) : ?>
									    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									        <?php the_post_thumbnail('large'); ?>
									    </a>
									<?php endif; ?>
								</div>
							</div>
						</article>
						<?php } ?>
					</div>
					<?php } 
                        wp_reset_query();
					?>
			
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.user-content__tabs li a').click(function(){
				$('.user-content__tabs li, .user-content__tabs li a').removeClass('is-active');
				$(this).addClass('is-active');
				$(this).parent().addClass('is-active');
				var href = $(this).attr('href');
				$('.user-content__content .tab-content').removeClass('is-active');
				$(href).addClass('is-active');
			});
		});
	</script>
 <?php endif; ?>
	<!--<div id="item-nav">
		<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Member primary navigation', 'buddypress' ); ?>" role="navigation">
			<ul>

				<?php //bp_get_displayed_user_nav(); ?>

				<?php

				/**
				 * Fires after the display of member options navigation.
				 *
				 * @since 1.2.4
				 */
				//do_action( 'bp_member_options_nav' ); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->
<?php if(!bp_is_user_activity()): ?>
	<div id="item-body">

		<?php

		/**
		 * Fires before the display of member body content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_body' );

		if ( bp_is_user_front() ) :
			bp_displayed_user_front_template_part();

		elseif ( bp_is_user_activity() ) :
			//bp_get_template_part( 'members/single/activity' );

		elseif ( bp_is_user_blogs() ) :
			//bp_get_template_part( 'members/single/blogs'    );

		elseif ( bp_is_user_friends() ) :
			bp_get_template_part( 'members/single/friends'  );

		elseif ( bp_is_user_groups() ) :
			bp_get_template_part( 'members/single/groups'   );

		elseif ( bp_is_user_messages() ) :
			bp_get_template_part( 'members/single/messages' );

		elseif ( bp_is_user_profile() ) :
			bp_get_template_part( 'members/single/profile'  );

		elseif ( bp_is_user_forums() ) :
			bp_get_template_part( 'members/single/forums'   );

		elseif ( bp_is_user_notifications() ) :
			bp_get_template_part( 'members/single/notifications' );

		elseif ( bp_is_user_settings() ) :
			bp_get_template_part( 'members/single/settings' );

		// If nothing sticks, load a generic template
		else :
			//bp_get_template_part( 'members/single/plugins'  );

		endif;

		/**
		 * Fires after the display of member body content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_body' ); ?>

	</div><!-- #item-body -->

	<?php
          endif;
	/**
	 * Fires after the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_home_content' ); ?>

</div><!-- #buddypress -->
<?php echo get_template_part('contact-user/index'); ?>
<div class="tooltip-content">
<div id="hire-me-button-tooltip"><ol><li>Provide job details and price</li><li>Designer negotiates or accepts </li><li>Pay the accepted price</li><li>Confirm job is done</li><li>Designer receives payment</li></ol></div>
</div>