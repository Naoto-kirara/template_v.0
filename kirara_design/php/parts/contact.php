<?php if (is_page('contact')) {; ?>
	<section>
		<div class="contact">
			<h2 class="contactMail_text">メールでのお問い合わせ</h2>
			<div class="contactMail">
				<ul class="contactMail_list">
					<li class="contactMail_item" style="background-image: url(/wp-content/uploads/z-76.png);">
						<a href="https://job.mynavi.jp/25/pc/search/corp222292/outline.html" target="_blank">
							<p class="contactMail_title_en">Recruit</p>
							<p class="contactMail_title_ja">採用に関するお問い合わせ</p>
						</a>
					</li>

					<li class="contactMail_item" style="background-image: url(/wp-content/uploads/contact_groupholdings.png);">
						<a href="/contact/form/">
							<p class="contactMail_title_en">Group holdings</p>
							<p class="contactMail_title_ja">グループホールディングスに<br>
								関するお問い合わせ</p>
						</a>
					</li>

				</ul>
			</div>
		</div>
	</section>
<?php } else {; ?>
	<!-- <aside>
		<div class="contact">
			<div class="contact_container">
				<div>
					<h2 class="contact_title">
						<span class="contact_title-en">Contact</span>
						<span class="contact_title-ja">お問い合わせ</span>
					</h2>
					<p class="contact_description">ご不明な点、サービスのお問い合わせについては<br>
						こちらのフォーム、またはお電話にてご連絡ください。</p>
				</div>
				<div class="contact_designBar"></div>
				<div class="contact_info">
					<div class="contact_btn">
						<div class="contact_btn-mail">
							<a href="/contact/form">
								<i class="icon icon_mail"></i>
								<span class="contact_btnText">お問合せフォーム</span>
							</a>
						</div>
					</div>
					<p class="contact_tel">TEL:0836-81-1111
						<span class="contact_openHour">営業時間　平日 10:00~18:00</span>
					</p>
				</div>
			</div>
		</div>
	</aside> -->
<?php }; ?>