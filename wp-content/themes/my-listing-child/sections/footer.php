<?php

$data = c27()->merge_options([

	'footer_text'      => c27()->get_setting('footer_text', ''),

	'show_widgets'     => c27()->get_setting('footer_show_widgets', true),

	'show_footer_menu' => c27()->get_setting('footer_show_menu', true),

], $data);

?>



<footer class="footer <?php echo esc_attr( ! $data['show_widgets'] ? 'footer-mini' : '' ) ?>">

	<div class="container">

		<?php if ( $data['show_widgets'] ): ?>

			<div class="row">

				<?php dynamic_sidebar('footer') ?>

			</div>

		<?php endif ?>



		<div class="row">

			<div class="col-md-12">

				<div class="footer-bottom">

					<div class="row">

							<div class="col-md-12 col-sm-12 col-xs-12 social-links">

								<?php echo do_shortcode("[hfe_template id='4714']"); ?>
								
							</div>


						<div class="col-md-12 col-sm-12 col-xs-12 copyright">

							<p><?php echo str_replace( '{{year}}', date('Y'), $data['footer_text'] ) ?></p>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</footer>

