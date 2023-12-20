<?php
use App\Models\User;
use App\Models\Appointment;

use Illuminate\Support\Facades\Mail;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$start = date('Y-m-d H:i:s', strtotime('+26 hours'));

$appointments = Appointment::where('startdate', '<=', $start)->where('startdate', '>=', date("Y-m-d H:i:s", strtotime("+25 hours")))
							->where('status', 1)
							->get();

$messageHeadCSS = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="x-apple-disable-message-reformatting">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="telephone=no" name="format-detection">
	<title></title>
	<!--[if (mso 16)]>
	<style type="text/css">
	a {text-decoration: none;}
	</style>
	<![endif]-->
	<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
		<o:AllowPNG></o:AllowPNG>
		<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
</head>
<style>
	#outlook a {
		padding: 0;
	}

	.ExternalClass {
		width: 100%;
	}

	.ExternalClass,
	.ExternalClass p,
	.ExternalClass span,
	.ExternalClass font,
	.ExternalClass td,
	.ExternalClass div {
		line-height: 100%;
	}

	.es-button {
		mso-style-priority: 100 !important;
		text-decoration: none !important;
	}

	a[x-apple-data-detectors] {
		color: inherit !important;
		text-decoration: none !important;
		font-size: inherit !important;
		font-family: inherit !important;
		font-weight: inherit !important;
		line-height: inherit !important;
	}

	.es-desk-hidden {
		display: none;
		float: left;
		overflow: hidden;
		width: 0;
		max-height: 0;
		line-height: 0;
		mso-hide: all;
	}

	[data-ogsb] .es-button {
		border-width: 0 !important;
		padding: 5px 15px 5px 15px !important;
	}

	/*
	END OF IMPORTANT
	*/
	s {
		text-decoration: line-through;
	}

	html,
	body {
		width: 100%;
		font-family: arial, \'helvetica neue\', helvetica, sans-serif;
		-webkit-text-size-adjust: 100%;
		-ms-text-size-adjust: 100%;
	}

	table {
		mso-table-lspace: 0pt;
		mso-table-rspace: 0pt;
		border-collapse: collapse;
		border-spacing: 0px;
	}

	table td,
	html,
	body,
	.es-wrapper {
		padding: 0;
		Margin: 0;
	}

	.es-content,
	.es-header,
	.es-footer {
		table-layout: fixed !important;
		width: 100%;
	}

	img {
		display: block;
		border: 0;
		outline: none;
		text-decoration: none;
		-ms-interpolation-mode: bicubic;
	}

	table tr {
		border-collapse: collapse;
	}

	p,
	hr {
		Margin: 0;
	}

	h1,
	h2,
	h3,
	h4,
	h5 {
		Margin: 0;
		line-height: 120%;
		mso-line-height-rule: exactly;
		font-family: arial, \'helvetica neue\', helvetica, sans-serif;
	}

	p,
	ul li,
	ol li,
	a {
		-webkit-text-size-adjust: none;
		-ms-text-size-adjust: none;
		mso-line-height-rule: exactly;
	}

	.es-left {
		float: left;
	}

	.es-right {
		float: right;
	}

	.es-p5 {
		padding: 5px;
	}

	.es-p5t {
		padding-top: 5px;
	}

	.es-p5b {
		padding-bottom: 5px;
	}

	.es-p5l {
		padding-left: 5px;
	}

	.es-p5r {
		padding-right: 5px;
	}

	.es-p10 {
		padding: 10px;
	}

	.es-p10t {
		padding-top: 10px;
	}

	.es-p10b {
		padding-bottom: 10px;
	}

	.es-p10l {
		padding-left: 10px;
	}

	.es-p10r {
		padding-right: 10px;
	}

	.es-p15 {
		padding: 15px;
	}

	.es-p15t {
		padding-top: 15px;
	}

	.es-p15b {
		padding-bottom: 15px;
	}

	.es-p15l {
		padding-left: 15px;
	}

	.es-p15r {
		padding-right: 15px;
	}

	.es-p20 {
		padding: 20px;
	}

	.es-p20t {
		padding-top: 20px;
	}

	.es-p20b {
		padding-bottom: 20px;
	}

	.es-p20l {
		padding-left: 20px;
	}

	.es-p20r {
		padding-right: 20px;
	}

	.es-p25 {
		padding: 25px;
	}

	.es-p25t {
		padding-top: 25px;
	}

	.es-p25b {
		padding-bottom: 25px;
	}

	.es-p25l {
		padding-left: 25px;
	}

	.es-p25r {
		padding-right: 25px;
	}

	.es-p30 {
		padding: 30px;
	}

	.es-p30t {
		padding-top: 30px;
	}

	.es-p30b {
		padding-bottom: 30px;
	}

	.es-p30l {
		padding-left: 30px;
	}

	.es-p30r {
		padding-right: 30px;
	}

	.es-p35 {
		padding: 35px;
	}

	.es-p35t {
		padding-top: 35px;
	}

	.es-p35b {
		padding-bottom: 35px;
	}

	.es-p35l {
		padding-left: 35px;
	}

	.es-p35r {
		padding-right: 35px;
	}

	.es-p40 {
		padding: 40px;
	}

	.es-p40t {
		padding-top: 40px;
	}

	.es-p40b {
		padding-bottom: 40px;
	}

	.es-p40l {
		padding-left: 40px;
	}

	.es-p40r {
		padding-right: 40px;
	}

	.es-menu td {
		border: 0;
	}

	.es-menu td a img {
		display: inline-block !important;
	}

	/* END CONFIG STYLES */
	a {
		text-decoration: none;
	}

	p,
	ul li,
	ol li {
		font-family: arial, \'helvetica neue\', helvetica, sans-serif;
		line-height: 150%;
	}

	ul li,
	ol li {
		Margin-bottom: 15px;
	}

	.es-menu td a {
		text-decoration: none;
		display: block;
		font-family: arial, \'helvetica neue\', helvetica, sans-serif;
	}

	.es-wrapper {
		width: 100%;
		height: 100%;
		background-image: ;
		background-repeat: repeat;
		background-position: center top;
	}

	.es-wrapper-color {
		background-color: #f6f6f6;
	}

	.es-header {
		background-color: transparent;
		background-image: ;
		background-repeat: repeat;
		background-position: center top;
	}

	.es-header-body {
		background-color: #666666;
	}

	.es-header-body p,
	.es-header-body ul li,
	.es-header-body ol li {
		color: #ffffff;
		font-size: 14px;
	}

	.es-header-body a {
		color: #ffffff;
		font-size: 14px;
	}

	.es-content-body {
		background-color: #ffffff;
	}

	.es-content-body p,
	.es-content-body ul li,
	.es-content-body ol li {
		color: #666666;
		font-size: 14px;
	}

	.es-content-body a {
		color: #0000FF;
		font-size: 14px;
	}

	.es-footer {
		background-color: transparent;
		background-image: ;
		background-repeat: repeat;
		background-position: center top;
	}

	.es-footer-body {
		background-color: #666666;
	}

	.es-footer-body p,
	.es-footer-body ul li,
	.es-footer-body ol li {
		color: #ffffff;
		font-size: 14px;
	}

	.es-footer-body a {
		color: #ffffff;
		font-size: 14px;
	}

	.es-infoblock,
	.es-infoblock p,
	.es-infoblock ul li,
	.es-infoblock ol li {
		line-height: 120%;
		font-size: 12px;
		color: #cccccc;
	}

	.es-infoblock a {
		font-size: 12px;
		color: #cccccc;
	}

	h1 {
		font-size: 30px;
		font-style: normal;
		font-weight: normal;
		color: #0000FF;
	}

	h2 {
		font-size: 24px;
		font-style: normal;
		font-weight: normal;
		color: #0000FF;
	}

	h3 {
		font-size: 20px;
		font-style: normal;
		font-weight: normal;
		color: #0000FF;
	}

	.es-header-body h1 a,
	.es-content-body h1 a,
	.es-footer-body h1 a {
		font-size: 30px;
	}

	.es-header-body h2 a,
	.es-content-body h2 a,
	.es-footer-body h2 a {
		font-size: 24px;
	}

	.es-header-body h3 a,
	.es-content-body h3 a,
	.es-footer-body h3 a {
		font-size: 20px;
	}

	a.es-button,
	button.es-button {
		border-style: solid;
		border-color: #ffffff;
		border-width: 5px 15px 5px 15px;
		display: inline-block;
		background: #ffffff;
		border-radius: 30px;
		font-size: 14px;
		font-family: arial, \'helvetica neue\', helvetica, sans-serif;
		font-weight: normal;
		font-style: normal;
		line-height: 120%;
		color: #0000FF;
		text-decoration: none;
		width: auto;
		text-align: center;
	}

	.es-button-border {
		border-style: solid solid solid solid;
		border-color: #0000FF #0000FF #0000FF #0000FF;
		background: #0000FF;
		border-width: 1px 1px 1px 1px;
		display: inline-block;
		border-radius: 30px;
		width: auto;
	}

	@media only screen and (max-width: 600px) {

		p,
		ul li,
		ol li,
		a {
			line-height: 150% !important;
		}

		h1,
		h2,
		h3,
		h1 a,
		h2 a,
		h3 a {
			line-height: 120% !important;
		}

		h1 {
			font-size: 30px !important;
			text-align: center;
		}

		h2 {
			font-size: 26px !important;
			text-align: center;
		}

		h3 {
			font-size: 20px !important;
			text-align: center;
		}

		.es-header-body h1 a,
		.es-content-body h1 a,
		.es-footer-body h1 a {
			font-size: 30px !important;
		}

		.es-header-body h2 a,
		.es-content-body h2 a,
		.es-footer-body h2 a {
			font-size: 26px !important;
		}

		.es-header-body h3 a,
		.es-content-body h3 a,
		.es-footer-body h3 a {
			font-size: 20px !important;
		}

		.es-menu td a {
			font-size: 16px !important;
		}

		.es-header-body p,
		.es-header-body ul li,
		.es-header-body ol li,
		.es-header-body a {
			font-size: 16px !important;
		}

		.es-content-body p,
		.es-content-body ul li,
		.es-content-body ol li,
		.es-content-body a {
			font-size: 16px !important;
		}

		.es-footer-body p,
		.es-footer-body ul li,
		.es-footer-body ol li,
		.es-footer-body a {
			font-size: 16 px !important;
		}

		.es-infoblock p,
		.es-infoblock ul li,
		.es-infoblock ol li,
		.es-infoblock a {
			font-size: 12px !important;
		}

		*[class="gmail-fix"] {
			display: none !important;
		}

		.es-m-txt-c,
		.es-m-txt-c h1,
		.es-m-txt-c h2,
		.es-m-txt-c h3 {
			text-align: center !important;
		}

		.es-m-txt-r,
		.es-m-txt-r h1,
		.es-m-txt-r h2,
		.es-m-txt-r h3 {
			text-align: right !important;
		}

		.es-m-txt-l,
		.es-m-txt-l h1,
		.es-m-txt-l h2,
		.es-m-txt-l h3 {
			text-align: left !important;
		}

		.es-m-txt-r img,
		.es-m-txt-c img,
		.es-m-txt-l img {
			display: inline !important;
		}

		.es-button-border {
			display: block !important;
		}

		a.es-button,
		button.es-button {
			font-size: 16px !important;
			display: block !important;
			border-width: 5px 15px 5px 15px !important;
		}

		.es-btn-fw {
			border-width: 10px 0px !important;
			text-align: center !important;
		}

		.es-adaptive table,
		.es-btn-fw,
		.es-btn-fw-brdr,
		.es-left,
		.es-right {
			width: 100% !important;
		}

		.es-content table,
		.es-header table,
		.es-footer table,
		.es-content,
		.es-footer,
		.es-header {
			width: 100% !important;
			max-width: 600px !important;
		}

		.es-adapt-td {
			display: block !important;
			width: 100% !important;
		}

		.adapt-img {
			width: 100% !important;
			height: auto !important;
		}

		.es-m-p0 {
			padding: 0px !important;
		}

		.es-m-p0r {
			padding-right: 0px !important;
		}

		.es-m-p0l {
			padding-left: 0px !important;
		}

		.es-m-p0t {
			padding-top: 0px !important;
		}

		.es-m-p0b {
			padding-bottom: 0 !important;
		}

		.es-m-p20b {
			padding-bottom: 20px !important;
		}

		.es-mobile-hidden,
		.es-hidden {
			display: none !important;
		}

		tr.es-desk-hidden,
		td.es-desk-hidden,
		table.es-desk-hidden {
			width: auto !important;
			overflow: visible !important;
			float: none !important;
			max-height: inherit !important;
			line-height: inherit !important;
		}

		tr.es-desk-hidden {
			display: table-row !important;
		}

		table.es-desk-hidden {
			display: table !important;
		}

		td.es-desk-menu-hidden {
			display: table-cell !important;
		}

		.es-menu td {
			width: 1% !important;
		}

		table.es-table-not-adapt,
		.esd-block-html table {
			width: auto !important;
		}

		table.es-social {
			display: inline-block !important;
		}

		table.es-social td {
			display: inline-block !important;
		}
	}
</style>
<body>
	<div class="es-wrapper-color">
		<!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#f6f6f6"></v:fill>
			</v:background>
		<![endif]-->
		<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td class="esd-email-paddings" valign="top">
						<table class="es-content esd-header-popover" cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td class="esd-stripe" align="center">
										<table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
											<tbody>
												<tr>
													<td class="esd-structure" align="left">
														<table width="100%" cellspacing="0" cellpadding="0">
															<tbody>
																<tr>
																	<td class="esd-container-frame" width="600" valign="top" align="center">
																		<table width="100%" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td class="esd-block-banner" style="position: relative;" align="center" esdev-config="h2"><a target="_blank" href="https://speakify24.de/"><img class="adapt-img esdev-stretch-width esdev-banner-rendered" src="https://speakify24.de/frontend/img/logo.png" alt="Speakify24" title="Speakify24" width="600" style="display: block;"></a></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table class="es-content" cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td class="esd-stripe" align="center">
										<table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
											<tbody>
												<tr>
													<td class="esd-structure es-p15t es-p15b es-p20r es-p20l" style="background-color: #eceff1;" bgcolor="#eceff1" align="left">
														<table width="100%" cellspacing="0" cellpadding="0">
															<tbody>
																<tr>
																	<td class="esd-container-frame" width="560" valign="top" align="center">
																		<table width="100%" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td class="esd-block-text" align="center">
																						<h2 style="color: #0000FF;">';
$messageBody = ',<br></h2>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-container-frame" width="600" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-block-image" align="center" style="font-size:0"><a target="_blank"><img src="https://tlr.stripocdn.email/content/guids/CABINET_3daeefbdf622b7d87abe9f2ce37a8cf4/images/85021517931052540.png" alt width="24"></a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p15t es-p20r es-p20l" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-container-frame" width="560" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-block-text" align="center">
	<p>';
$messageBodyDate = '<br></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
<table cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td class="esd-container-frame" width="560" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-block-text es-p5b es-m-txt-c" align="center">
	<p style="color: #0000FF; font-size: 18px;">Wann:</p>
</td>
</tr>
<tr>
<td class="esd-block-text es-m-txt-c" align="center">
	<p style="color: #666666;">';
$messageBodyTime = '</p>
<p style="color: #666666;">';
$messageRemainFooter = '</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-container-frame" width="600" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-block-spacer es-p10t es-p10b es-p20r es-p20l" bgcolor="#f6f6f6" align="center" style="font-size:0">
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td style="border-bottom: 1px solid #f6f6f6; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
			</tr>
		</tbody>
	</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table cellpadding="0" cellspacing="0" class="es-footer esd-footer-popover" align="center">
<tbody>
<tr>
<td class="esd-stripe" esd-custom-block-id="5804" align="center">
<table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td class="esd-structure es-p20t es-p20b es-p40r es-p40l" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-container-frame" width="520" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-block-text es-p10t" align="center">
	<p>© '.date('Y').' Speakify24</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</body>

</html>';
if (count($appointments) > 0) {
	foreach ($appointments as $appointment) {
		$appointment->instructor = User::find($appointment->instructor_id);
		$appointment->student = User::find($appointment->user_id);

		$data = $appointment;

		if ($appointment->instructor->timezone != '') {
			date_default_timezone_set($appointment->instructor->timezone);
		} else {
			date_default_timezone_set('Europe/Berlin');
		}

		\Mail::send([], [
			'data' => $data,
			'messageHeadCSS' => $messageHeadCSS,
			'messageBody' => $messageBody,
			'messageBodyDate' => $messageBodyDate,
			'messageBodyTime' => $messageBodyTime,
			'messageRemainFooter' => $messageRemainFooter
		], function ($message) use($data, $messageHeadCSS, $messageBody, $messageBodyDate, $messageBodyTime, $messageRemainFooter){
			$MailBody = 'Hi '.$data->instructor->first_name.' '.$data->instructor->last_name.'!<br /><br />Your appointment is schedule with '.$data->student->first_name.' '.$data->student->last_name.' on '.date('d-m-Y h:i', strtotime($data->startdate)).'<br /><br />Thanks!';
			$mailBody = $messageHeadCSS;
			$mailBody .= 'Hallo ' . $data->instructor->first_name.' '.$data->instructor->last_name;
			$mailBody .= $messageBody;
			$mailBody .= 'wir wollen dich daran erinnern, dass dein Unterricht bald beginnt.<br></p>';
			$mailBody .= '<p>Am '.date('d-m-Y', strtotime($data->startdate)).' um '.date('h:i', strtotime($data->startdate)).' hast du mit '.$data->student->first_name.' '.$data->student->last_name.' unterricht.<br></p>';
			$mailBody .= '<p>Logge dich dazu bitte unter www.speakify24.de ein und klicke auf das blaue Kamerasymbol.<br></p>';
			$mailBody .= '<p>Viel Spaß beim Unterricht!<br></p>';
			$mailBody .= '<p>Dein Speakify24 Team';
			$mailBody .= $messageBodyDate;
			$mailBody .= date('d-m-Y', strtotime($data->startdate));
			$mailBody .= $messageBodyTime;
			$mailBody .= date('h:i', strtotime($data->startdate));
			$mailBody .= $messageRemainFooter;
			$message->setBody($mailBody, 'text/html');
			$message->subject('Appointment Reminder');
			$message->from('registration@speakify24.com', 'Speakify24 Team');
			$message->to($data->instructor->email);
		});

		if ($appointment->student->timezone != '') {
			date_default_timezone_set($appointment->student->timezone);
		} else {
			date_default_timezone_set('Europe/Berlin');
		}

		\Mail::send([], [
			'data' => $data,
			'messageHeadCSS' => $messageHeadCSS,
			'messageBody' => $messageBody,
			'messageBodyDate' => $messageBodyDate,
			'messageBodyTime' => $messageBodyTime,
			'messageRemainFooter' => $messageRemainFooter
		], function ($message) use($data, $messageHeadCSS, $messageBody, $messageBodyDate, $messageBodyTime, $messageRemainFooter){
			$MailBody = 'Hi '.$data->student->first_name.' '.$data->student->last_name.'!<br /><br />Your appointment is schedule with '.$data->instructor->first_name.' '.$data->instructor->last_name.' on '.date('d-m-Y h:i', strtotime($data->startdate)).'<br /><br />Thanks!';
			$mailBody = $messageHeadCSS;
			$mailBody .= 'Hallo ' . $data->student->first_name.' '.$data->student->last_name;
			$mailBody .= $messageBody;
			$mailBody .= 'wir wollen dich daran erinnern, dass dein Unterricht bald beginnt.<br></p>';
			$mailBody .= '<p>Am '.date('d-m-Y', strtotime($data->startdate)).' um '.date('h:i', strtotime($data->startdate)).' hast du mit '.$data->instructor->first_name.' '.$data->instructor->last_name.' unterricht.<br></p>';
			$mailBody .= '<p>Logge dich dazu bitte unter www.speakify24.de ein und klicke auf das blaue Kamerasymbol.<br></p>';
			$mailBody .= '<p>Viel Spaß beim Unterricht!<br></p>';
			$mailBody .= '<p>Dein Speakify24 Team';
			$mailBody .= $messageBodyDate;
			$mailBody .= date('d-m-Y', strtotime($data->startdate));
			$mailBody .= $messageBodyTime;
			$mailBody .= date('h:i', strtotime($data->startdate));
			$mailBody .= $messageRemainFooter;
			$message->setBody($mailBody, 'text/html');
			$message->subject('Appointment Reminder');
			$message->from('registration@speakify24.com', 'Speakify24 Team');
			$message->to($data->student->email);
		});

		$log_filename = "log";
		if (!file_exists($log_filename)) {
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';

		file_put_contents($log_file_data, "Email send to Student " . $appointment->student->first_name . " " . $appointment->student->last_name . " (" .$appointment->student->id. ") and Instructor " . $appointment->instructor->first_name . " " . $appointment->instructor->last_name . " (" .$appointment->instructor->id. ")." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
	}
	
	echo 'Appointment Reminder sent successfully.'; exit;
} else {
	$log_filename = "log";
	if (!file_exists($log_filename)) {
		mkdir($log_filename, 0777, true);
	}
	$log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';

	file_put_contents($log_file_data, "No appointment found." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
	echo 'No Appointment found.'; exit;
}

?>