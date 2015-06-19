<table class="head-wrap" bgcolor="#999999">
	<tbody>
		<tr>
			<td></td>
			<td class="header container">
				<div class="content">
					<table bgcolor="#999999">
						<tbody>
							<tr>
								<td>[CO_LOGO]</td>
								<td align="right">
									<h6 class="collapse">[COMPANY]</h6>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>

<table class="body-wrap">
	<tbody>
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">
				<div class="content">
					<table>
						<tbody>
							<tr>
								<td>
									<h1><?php printf( __( 'Hello, %s:', 'event_espresso' ), '[PRIMARY_REGISTRANT_FNAME]' ); ?></h1>
									<?php _e( 'Here\'s a summary of all the registrations recently made:', 'event_espresso' ); ?>
									<div>
										[EVENT_LIST]
									</div>
									[PAYMENT_LINK_IF_NEEDED_* container_tag=p class=callout custom_text='You can %smake a payment here »%s.']
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>

<table class="footer-wrap">
	<tbody>
		<tr>
			<td></td>
			<td class="container">
				<table class="social" width="100%">
					<tbody>
						<tr>
							<td>
								<table class="column" align="left">
									<tbody>
										<tr>
											<td>
												<h5><?php _e( 'Connect with Us:', 'event_espresso' ); ?></h5>
												<a class="soc-btn fb" href="[CO_FACEBOOK_URL]"><?php _e( 'Facebook', 'event_espresso' ); ?></a>
												<a class="soc-btn tw" href="[CO_TWITTER_URL]"><?php _e( 'Twitter', 'event_espresso' ); ?></a>
												<a class="soc-btn gp" href="[CO_GOOGLE_URL]"><?php _e( 'Google+', 'event_espresso' ); ?></a>
											</td>
										</tr>
									</tbody>
								</table>

								<table class="column" align="left">
									<tbody>
										<tr>
											<td>
												<h5><?php _e( 'Contact Info:', 'event_espresso' ); ?></h5>
												<?php _e( 'Phone:', 'event_espresso' ); ?> <strong>[CO_PHONE]</strong>
												<?php _e( 'Email:', 'event_espresso' ); ?>
												<strong><a href="mailto:[CO_EMAIL]" target="_blank">[CO_EMAIL]</a></strong>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>
