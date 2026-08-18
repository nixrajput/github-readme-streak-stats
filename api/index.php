<?php

declare(strict_types=1);

// load functions
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
require_once "stats.php";
require_once "card.php";
require_once "cache.php";
require_once "generator.php";

// load .env
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

// if environment variables are not loaded, display error
if (!isset($_ENV["TOKEN"])) {
    $message = file_exists(dirname(__DIR__, 1) . "/.env")
        ? "Missing token in config. Check Contributing.md for details."
        : ".env was not found. Check Contributing.md for details.";
    renderOutput($message, 500);
}

// set cache to refresh once per day (24 hours)
$cacheSeconds = CACHE_DURATION;
header("Expires: " . gmdate("D, d M Y H:i:s", time() + $cacheSeconds) . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: public, max-age=$cacheSeconds");

// Serve the landing page when no user is given. Previously redirected to demo/,
// which no longer ships: the demo is three PHP files and each becomes its own
// lambda, which pushed the deployment over Vercel's per-deployment ceiling.
if (!isset($_REQUEST["user"])) {
    header("Content-Type: text/html; charset=utf-8");
    // Override the 24h card cache set above. A landing page pinned for a day
    // means any change to it sticks in every visitor's browser until it expires.
    header("Cache-Control: public, max-age=300");
    echo <<<'HTML'
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>github-readme-streak-stats</title>
<meta name="description" content="Self-hosted GitHub contribution streak card service.">
<meta name="color-scheme" content="dark">
<link rel="icon" href="data:image/svg+xml,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%2796%27%20height%3D%2796%27%20viewBox%3D%270%200%2032%2032%27%3E%20%3Ctitle%3Egithub-readme-streak-stats%3C%2Ftitle%3E%20%3Crect%20width%3D%2732%27%20height%3D%2732%27%20rx%3D%277%27%20fill%3D%27%23141118%27%20%2F%3E%20%3C%21--%20A%20contribution%20row%20where%20the%20unbroken%20run%20is%20lit%20and%20the%20day%20ahead%20is%20still%20open%3A%20the%20card%20measures%20consecutive%20days%2C%20so%20the%20gap%20on%20the%20left%20is%20the%20point.%20Deliberately%20not%20a%20flame%2C%20which%20every%20streak%20widget%20uses%20and%20which%20says%20nothing%20about%20continuity.%20--%3E%20%3Crect%20x%3D%276%27%20y%3D%2713.4%27%20width%3D%275.2%27%20height%3D%275.2%27%20rx%3D%271.7%27%20fill%3D%27%236b6478%27%20%2F%3E%20%3Crect%20x%3D%2713.4%27%20y%3D%2713.4%27%20width%3D%275.2%27%20height%3D%275.2%27%20rx%3D%271.7%27%20fill%3D%27%239b8cff%27%20%2F%3E%20%3Crect%20x%3D%2720.8%27%20y%3D%2713.4%27%20width%3D%275.2%27%20height%3D%275.2%27%20rx%3D%271.7%27%20fill%3D%27%239b8cff%27%20%2F%3E%20%3Cpath%20d%3D%27M8.6%2023.5h9.4%27%20stroke%3D%27%23f0a868%27%20stroke-width%3D%272.2%27%20stroke-linecap%3D%27round%27%20%2F%3E%20%3Ccircle%20cx%3D%2723.4%27%20cy%3D%2723.5%27%20r%3D%271.6%27%20fill%3D%27%23f0a868%27%20%2F%3E%20%3C%2Fsvg%3E">
<style>*{box-sizing:border-box}
:root{--bg:#100f15;--surface:#191822;--line:#2b2836;--text:#e9e6ef;--dim:#9a93ad;--violet:#9b8cff;--amber:#f0a868;
--mono:ui-monospace,SFMono-Regular,"SF Mono",Menlo,Consolas,monospace;
--sans:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
html{color-scheme:dark}
body{margin:0;background:var(--bg);color:var(--text);font:15px/1.6 var(--sans);
padding:clamp(2rem,7vw,4.5rem) 1.25rem 5rem;-webkit-font-smoothing:antialiased}
main{max-width:44rem;margin:0 auto}
.mark{display:block;width:64px;height:64px;margin:0 0 1.5rem}
h1{font:700 clamp(1.35rem,4.5vw,1.9rem)/1.1 var(--mono);letter-spacing:-.02em;margin:0 0 .5rem;word-break:break-word}
.tag{color:var(--dim);margin:0 0 2.5rem;max-width:34rem}
.demo{margin:0 0 2.5rem;padding:0}
.demo img{display:block;max-width:100%;height:auto;border-radius:6px}
.demo figcaption{margin-top:.85rem}
.url{display:block;overflow-x:auto;white-space:nowrap;background:var(--surface);border:1px solid var(--line);
border-radius:5px;padding:.65rem .8rem;font:12.5px/1.5 var(--mono);color:var(--dim)}
.url b{color:var(--amber);font-weight:400}
h2{font:600 .72rem/1 var(--mono);letter-spacing:.14em;text-transform:uppercase;color:var(--violet);
margin:0 0 .9rem}
section{margin:0 0 2.5rem}
dl{display:grid;grid-template-columns:auto 1fr;gap:.5rem 1.1rem;margin:0;font-size:14px}
dt{font:400 13px/1.6 var(--mono);color:var(--amber)}
dd{margin:0;color:var(--dim)}
footer{border-top:1px solid var(--line);padding-top:1.25rem;color:var(--dim);font-size:13.5px}
a{color:var(--violet);text-underline-offset:3px}
a:focus-visible{outline:2px solid var(--violet);outline-offset:3px;border-radius:2px}
.note{color:var(--dim);font-size:13.5px;margin:.6rem 0 0}
@media(max-width:30rem){dl{grid-template-columns:1fr;gap:.15rem}dd{margin-bottom:.6rem}}</style>
</head>
<body>
<main>
  <svg class="mark" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 32 32">
  <title>github-readme-streak-stats</title>
  <rect width="32" height="32" rx="7" fill="#141118" />
  <!-- A contribution row where the unbroken run is lit and the day ahead is still open:
       the card measures consecutive days, so the gap on the left is the point. Deliberately
       not a flame, which every streak widget uses and which says nothing about continuity. -->
  <rect x="6" y="13.4" width="5.2" height="5.2" rx="1.7" fill="#6b6478" />
  <rect x="13.4" y="13.4" width="5.2" height="5.2" rx="1.7" fill="#9b8cff" />
  <rect x="20.8" y="13.4" width="5.2" height="5.2" rx="1.7" fill="#9b8cff" />
  <path d="M8.6 23.5h9.4" stroke="#f0a868" stroke-width="2.2" stroke-linecap="round" />
  <circle cx="23.4" cy="23.5" r="1.6" fill="#f0a868" />
</svg>
  <h1>github-readme-streak-stats</h1>
  <p class="tag">Renders total contributions, current streak and longest streak as an SVG, for embedding in a README.</p>

  <figure class="demo">
    <img src="/?user=nixrajput&amp;hide_border=true&amp;theme=dark" alt="Example streak card for nixrajput" loading="eager">
    <figcaption><code class="url">https://github-readme-streak-stats.nixrajput.com/?<b>user</b>=nixrajput&amp;hide_border=true&amp;theme=dark</code></figcaption>
  </figure>

  <section>
    <h2>Parameters</h2>
    <dl>
      <dt>user</dt><dd>GitHub username. Required.</dd>
      <dt>theme</dt><dd>One of 166 themes, e.g. <code>dark</code>.</dd>
      <dt>hide_border</dt><dd><code>true</code> to drop the card border.</dd>
      <dt>locale</dt><dd>One of 63 locales, e.g. <code>hi</code>.</dd>
      <dt>date_format</dt><dd>Custom date format, e.g. <code>[Y.]n.j</code>.</dd>
      <dt>background</dt><dd>Hex, CSS colour, or a gradient.</dd>
    </dl>
  </section>

  <footer>
    Self-hosted instance, restricted to whitelisted usernames.
    <a href="https://github.com/nixrajput/github-readme-streak-stats">Source and full options on GitHub</a>.
    <p class="note">Not on the list? Deploy your own from the repo - it is MIT licensed.</p>
  </footer>
</main>
</body>
</html>
HTML;
    exit();
}

try {
    $stats = generateStreakStats($_REQUEST["user"], $_REQUEST);
    renderOutput($stats);
} catch (InvalidArgumentException | AssertionError $error) {
    error_log("Error {$error->getCode()}: {$error->getMessage()}");
    if ($error->getCode() >= 500) {
        error_log($error->getTraceAsString());
    }
    renderOutput($error->getMessage(), $error->getCode());
}
