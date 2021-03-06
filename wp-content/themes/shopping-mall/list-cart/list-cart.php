<?php
 $cart_total = WC()->cart->get_cart_contents_count();
 ?>
<div id="cart-box-content" class="popover-box">
									<div class="popover-box__inner">
									   <h4 class="popover-box__title">Shopping cart</h4>
									  You have <span class="indicator cart-indicator"><?php echo $cart_total; ?></span> items in your shopping cart.
									</div>
									<div class="popover-box__inner">
									   
									     <?php
                                             global $woocommerce;
    										 $items = $woocommerce->cart->get_cart();
    										 if($items){
    										 	?>
    										 	<div class="product-list product-list--on-contrast">
    										 	<?php 
    										 	  foreach ($items as $cart_item_key => $item) {
    										 	  	 $_product = $item['data']->post;
    										 	  	 $title =  $_product->post_title;
    										 	  	 $link = get_permalink($_product->id);
    										 	  	 $price = get_post_meta($item['product_id'] , '_price', true);
    										 	  	 $img = new WC_Product($_product->id);
    										 	  	 $taxs = get_the_terms($_product->id,'product_cat');
    										 	  	 $tax = ($taxs) ? $taxs[0]->name :''; 

    										 	  	 
    										 	  	?>
                                               <article class="product-list__item">
											         <div class="product-list__item-preview">
											         	
												        <?php
															$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $img->get_image(), $item, $cart_item_key );

															if ( ! $product_permalink ) {
																echo $thumbnail;
															} else {
																printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
															}
														?>
											         </div>
									         <div class="product-list__item-info">
									            <h1 class="product-list__item-title"><a href="<?php echo $link;?>"><?php echo $title; ?></a></h1>
									            <div class="product-list__item-summary"><?php echo $tax; ?></div>
									         </div>
									         <div class="product-list__item-price">
									               <?php echo $price; ?>
									         </div>
									         <div class="product-list__item-remove has-tooltip tooltipstered">
									           <a href="<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ) ); ?>"><i class="fa fa-times-circle-o fa-lg"></i></a>
									         
						</div>
									      </article>
    										 	  	<?php 
    										 	  
    										 	  }
    										 	 ?>

										  </div>
											   <div class="popover-box__actions">
											      <a href="<?php echo wc_get_cart_url(); ?>">
											         <i class="fa fa-shopping-cart fa-lg"></i> View cart
											      </a>
											      <a class="button button--compact button--alt u-float-right" href="<?php echo $woocommerce->cart->get_checkout_url(); ?>">
											         <i class="fa fa-shopping-bag"></i>Proceed to checkout
											      </a>
											   </div>
    										<?php 
    										 
    										 }

									      ?>
		</div>
</div>