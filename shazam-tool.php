<?php
//list icones
$check = "<i class='fas fa-check-square'></i>";
$bugs = '<i class="fas fa-bug"></i>';
$flash = '<i class="fas fa-bolt"></i>';
$close = '<i class="fas fa-times"></i>';
$param = '<i class="fas fa-cogs"></i>';
$hdd = '<i class="fas fa-hdd"></i>';
$user_id = '<i class="fas fa-user"></i>';

if(isset($_GET['url'])){
		$lien = htmlspecialchars($_GET['url']);
		$p = "<div class='status-message'><span class='icon'>$param</span> Connecting to site...</div>";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $lien);

		if(isset($_GET['useragent'])){
				curl_setopt($ch, CURLOPT_USERAGENT, $_GET['useragent']);
		}else{
				curl_setopt($ch, CURLOPT_USERAGENT, "SHAZAM Scanner");
		}

		if(isset($_GET['ssl'])){
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $_GET["ssl"]);
		}else{
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}

		if(isset($_GET['loc'])){
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $_GET["loc"]);
		}else{
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$r = htmlspecialchars(curl_exec($ch));
		$xx = nl2br($r);

		if(curl_errno($ch)){
				$e = "<div class='status-message error'><span class='icon'>$close</span> Error: " . curl_error($ch) . "</div>";
		}

		$s = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($s == 200){
				$p1 = "<div class='status-message success'><span class='icon'>$check</span> Source code found</div>";
				$p2 = "<div class='source-code'>" . $xx . "</div>";
				$p3 = "<div class='footer-message'><span class='icon'>$user_id</span> Developed by Hacker Protector</div>";
		}
		elseif($s == 404){
				$p1 = "<div class='status-message error'><span class='icon'>$bugs</span> Source code not found [404]</div>";
				$p2 = "<div class='status-message error'><span class='icon'>$close</span> Connection closed</div>";
				$p3 = "<div class='footer-message'><span class='icon'>$user_id</span> Developed by Hacker Protector</div>";
		}else{
				$p1 = "<div class='status-message error'><span class='icon'>$bugs</span> Source code not found [$s]</div>";
				$p2 = "<div class='status-message error'><span class='icon'>$close</span> Connection closed</div>";
				$p3 = "<div class='footer-message'><span class='icon'>$user_id</span> Developed by Hacker Protector</div>";
		}

		$result = @$p . @$e . @$p1 . @$p2 . @$p3;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SHAZAM - Web Request Analyzer</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-tomorrow.min.css" rel="stylesheet">
		<style>
				:root {
						--primary-color: #00ff00;
						--background-dark: #0a0a0a;
						--card-background: #111111;
						--text-color: #ffffff;
						--accent-color: #1a1a1a;
						--success-color: #51E690;
						--error-color: #FF285B;
						--warning-color: #F4DF62;
				}

				* {
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						font-family: 'Segoe UI', sans-serif;
				}

				body {
						background-color: var(--background-dark);
						color: var(--text-color);
						min-height: 100vh;
						padding: 2rem;
				}

				.container {
						max-width: 1200px;
						margin: 0 auto;
				}

				.header {
						text-align: center;
						margin-bottom: 3rem;
						animation: fadeIn 1s ease-in;
				}

				@keyframes fadeIn {
						from { opacity: 0; transform: translateY(-20px); }
						to { opacity: 1; transform: translateY(0); }
				}

				.logo {
						font-size: 3rem;
						color: var(--primary-color);
						margin-bottom: 1rem;
						animation: pulse 2s infinite;
				}

				.title {
						font-size: 2.5rem;
						color: var(--primary-color);
						margin-bottom: 1rem;
						font-family: "Audiowide", sans-serif;
				}

				.description {
						color: #888;
						margin-bottom: 2rem;
				}

				.control-panel {
						background: var(--card-background);
						border-radius: 12px;
						padding: 2rem;
						margin-bottom: 2rem;
						border: 1px solid #222;
				}

				.url-input {
						width: 100%;
						padding: 1rem;
						background: var(--accent-color);
						border: 1px solid #333;
						border-radius: 8px;
						color: var(--text-color);
						margin-bottom: 1rem;
				}

				.options-grid {
						display: grid;
						grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
						gap: 1rem;
						margin-bottom: 1rem;
				}

				.option-item {
						display: flex;
						align-items: center;
						gap: 0.5rem;
				}

				.submit-btn {
						width: 100%;
						padding: 1rem;
						background: var(--primary-color);
						border: none;
						border-radius: 8px;
						color: var(--background-dark);
						font-weight: bold;
						cursor: pointer;
						transition: all 0.3s ease;
				}

				.status-message {
						padding: 1rem;
						margin-bottom: 0.5rem;
						border-radius: 8px;
						display: flex;
						align-items: center;
						gap: 0.5rem;
				}

				.status-message.success {
						background: rgba(81, 230, 144, 0.1);
						color: var(--success-color);
				}

				.status-message.error {
						background: rgba(255, 40, 91, 0.1);
						color: var(--error-color);
				}

				.source-code {
						background: var(--accent-color);
						padding: 1rem;
						border-radius: 8px;
						margin: 1rem 0;
						white-space: pre-wrap;
						overflow-x: auto;
				}

				.footer-message {
						padding: 1rem;
						color: var(--warning-color);
						text-align: center;
						border-top: 1px solid #333;
						margin-top: 1rem;
				}

				.icon {
						width: 20px;
						text-align: center;
				}

				@media (max-width: 768px) {
						.container {
								padding: 1rem;
						}

						.title {
								font-size: 2rem;
						}

						.options-grid {
								grid-template-columns: 1fr;
						}
				}
		</style>
</head>
<body>
		<div class="container">
				<header class="header">
						<div class="logo">
								<i class="fas fa-bolt"></i>
						</div>
						<h1 class="title">SHAZAM</h1>
						<p class="description">Advanced Web Request Analysis Tool</p>
				</header>

				<form method="GET" class="control-panel">
						<input type="url" name="url" class="url-input" placeholder="Enter URL to analyze..." required>

						<div class="options-grid">
								<div class="option-item">
										<input type="checkbox" id="userAgentCheck" class="custom-checkbox" onclick="toggleInput('userAgent')">
										<label for="userAgentCheck">
												<i class="fas fa-user-secret"></i> Custom User Agent
										</label>
										<input type="text" name="useragent" id="userAgent" class="option-input" placeholder="Enter User Agent">
								</div>

								<div class="option-item">
										<input type="checkbox" id="sslCheck" name="ssl" class="custom-checkbox">
										<label for="sslCheck">
												<i class="fas fa-lock"></i> Verify SSL Certificate
										</label>
								</div>

								<div class="option-item">
										<input type="checkbox" id="redirectCheck" name="loc" class="custom-checkbox">
										<label for="redirectCheck">
												<i class="fas fa-random"></i> Follow Redirections
										</label>
								</div>
						</div>

						<button type="submit" class="submit-btn">
								<i class="fas fa-search"></i> Analyze URL
						</button>
				</form>

				<?php if(isset($result)): ?>
				<div class="control-panel">
						<?php echo $result; ?>
				</div>
				<?php endif; ?>
		</div>

		<script>
				function toggleInput(inputId) {
						const input = document.getElementById(inputId);
						input.classList.toggle('active');
				}
		</script>
</body>
</html>