<?php
    $email_contents = $GLOBALS['email_contents'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $email_contents['title']; ?></title>
</head>
<body style="background: #ededed; padding: 0; margin: 0; font-family: sans-serif;" >
	
	<div id="header" style="display: block; width: 100%; background: #fff; text-align: center; padding: 40px 10px;" >
		<img style="display: inline-block; max-width: 60%; margin: 0 20%" src="<?php bloginfo('template_directory'); ?>/images/logos/TEDX_losangeles.svg">
	</div>

	<div id="cuerpo" style="padding: 40px 0;" >
		<div style="background: #ffffff; padding: 40px; width: 600px; max-width: 100%; margin: 0 auto; box-sizing: border-box;" >
			<table style="border-collapse: collapse; width: 100%;" >
				<tr>
					<td>
						<h1 style="display: block; font-size: 14px; font-weight: bold; margin: 0 0 1.5em 0; color: #84001A;">
							<?php echo $email_contents['intro']; ?>
						</h1>

						<div style="display: block; font-size: 14px; color: #333; margin-bottom: 40px;" >
							<?php echo $email_contents['mensaje']; ?>
						</div>

						<p style="font-size: 11px;" >Por favor, no responda a este correo.</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>