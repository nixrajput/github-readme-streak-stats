<div align="center">

<img src="https://raw.githubusercontent.com/nixrajput/github-readme-streak-stats/main/assets/logo.svg" width="76" alt="github-readme-streak-stats">

# github-readme-streak-stats

<em>Total contributions, current streak and longest streak, rendered as an SVG card.</em>

<br />

[![Stars](https://img.shields.io/github/stars/nixrajput/github-readme-streak-stats?color=159F7C)][repo]
[![License: MIT](https://img.shields.io/github/license/nixrajput/github-readme-streak-stats?color=159F7C)][license]
[![Last commit](https://img.shields.io/github/last-commit/nixrajput/github-readme-streak-stats?label=last%20commit)][repo]
[![Issues](https://img.shields.io/github/issues/nixrajput/github-readme-streak-stats?label=issues)][issues]
[![PRs](https://img.shields.io/github/issues-pr/nixrajput/github-readme-streak-stats?label=PRs)][pulls]

<strong>Self-hosted &middot; own PAT &middot; 166 themes &middot; 63 locales &middot; PHP on Vercel</strong><br>
<sub>Runs on our own Vercel deployment rather than a shared public instance, so the card does not compete for someone else's rate limit. Derived from the upstream <code>vercel</code> branch, which is the one that carries <code>vercel.json</code> and <code>api/</code> - upstream's <code>main</code> does not, and deploying it returns 404.</sub>

</div>

---

## Contents

- [github-readme-streak-stats](#github-readme-streak-stats)
  - [Contents](#contents)
  - [Usage](#usage)
  - [🔧 Options](#-options)
  - [ℹ️ How these stats are calculated](#-how-these-stats-are-calculated)
  - [🛠 Local development](#-local-development)
  - [🚀 Deployment](#-deployment)
  - [Contributing](#contributing)
  - [Contributors](#contributors)
  - [License](#license)
  - [Support the project](#support-the-project)
  - [Connect](#connect)

Self-hosted service behind the streak card on [nixrajput's profile README](https://github.com/nixrajput).
Runs on our own Vercel deployment and our own GitHub token, so the card does not depend on a
shared public instance or compete for its rate limit.

**Endpoint:** `https://github-readme-streak-stats.nixrajput.com`

## Usage

```md
[![GitHub Streak](https://github-readme-streak-stats.nixrajput.com?user=nixrajput)](https://github.com/nixrajput/github-readme-streak-stats)
```

Theme-aware embedding, which is what the profile README uses. The `#gh-dark-mode-only`
fragment is deprecated and no longer switches images, so use `<picture>`:

```html
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://github-readme-streak-stats.nixrajput.com?user=nixrajput&theme=dark" />
  <img src="https://github-readme-streak-stats.nixrajput.com?user=nixrajput&theme=default" alt="GitHub Streak" />
</picture>
```

## 🔧 Options

The `user` field is the only required option. All other fields are optional.

If the `theme` parameter is specified, any color customizations specified will be applied on top of the theme, overriding the theme's values.

|         Parameter          |                     Details                      |                                              Example                                               |
| :------------------------: | :----------------------------------------------: | :------------------------------------------------------------------------------------------------: |
|           `user`           |        GitHub username to show stats for         |                                           `nixrajput`                                           |
|          `theme`           |     The theme to apply (Default: `default`)      |                          `dark`, `radical`, etc. [🎨➜](./docs/themes.md)                           |
|       `hide_border`        |  Make the border transparent (Default: `false`)  |                                         `true` or `false`                                          |
|      `border_radius`       | Set the roundness of the edges (Default: `4.5`)  |                           Number `0` (sharp corners) to `248` (ellipse)                            |
|        `background`        |  Background color (eg. `f2f2f2`, `35,d22,00f`)   | **hex code** without `#`, **css color**, or gradient in the form `angle,start_color,...,end_color` |
|          `border`          |                   Border color                   |                             **hex code** without `#` or **css color**                              |
|          `stroke`          |        Stroke line color between sections        |                             **hex code** without `#` or **css color**                              |
|           `ring`           |   Color of the ring around the current streak    |                             **hex code** without `#` or **css color**                              |
|           `fire`           |          Color of the fire in the ring           |                             **hex code** without `#` or **css color**                              |
|      `currStreakNum`       |              Current streak number               |                             **hex code** without `#` or **css color**                              |
|         `sideNums`         |         Total and longest streak numbers         |                             **hex code** without `#` or **css color**                              |
|     `currStreakLabel`      |               Current streak label               |                             **hex code** without `#` or **css color**                              |
|        `sideLabels`        |         Total and longest streak labels          |                             **hex code** without `#` or **css color**                              |
|          `dates`           |              Date range text color               |                             **hex code** without `#` or **css color**                              |
|     `excludeDaysLabel`     |       Excluded days of the week text color       |                             **hex code** without `#` or **css color**                              |
|       `date_format`        |  Date format pattern or empty for locale format  |                        See note below on [📅 Date Formats](#-date-formats)                         |
|          `locale`          |  Locale for labels and numbers (Default: `en`)   |                            ISO 639-1 code - See [🗪 Locales](#-locales)                             |
|      `short_numbers`       |  Use short numbers (e.g. 1.5k instead of 1,500)  |                                         `true` or `false`                                          |
|           `type`           |          Output format (Default: `svg`)          |                              Current options: `svg`, `png` or `json`                               |
|           `mode`           |          Streak mode (Default: `daily`)          |             `daily` (contribute daily) or `weekly` (contribute once per Sun-Sat week)              |
|       `exclude_days`       | List of days of the week to exclude from streaks |    Comma-separated list of day abbreviations (Sun, Mon, Tue, Wed, Thu, Fri, Sat) e.g. `Sun,Sat`    |
|    `disable_animations`    |    Disable SVG animations (Default: `false`)     |                                         `true` or `false`                                          |
|        `card_width`        |   Width of the card in pixels (Default: `495`)   |                        Positive integer, minimum width is 100px per column                         |
|       `card_height`        |  Height of the card in pixels (Default: `195`)   |                             Positive integer, minimum height is 170px                              |
| `hide_total_contributions` | Hide the total contributions (Default: `false`)  |                                         `true` or `false`                                          |
|   `hide_current_streak`    |    Hide the current streak (Default: `false`)    |                                         `true` or `false`                                          |
|   `hide_longest_streak`    |    Hide the longest streak (Default: `false`)    |                                         `true` or `false`                                          |
|      `starting_year`       |          Starting year of contributions          |   Integer, must be `2005` or later, eg. `2017`. By default, your account creation year is used.    |

### 🖌 Themes

To enable a theme, append `&theme=` followed by the theme name to the end of the source URL:

```md
[![GitHub Streak](https://github-readme-streak-stats.nixrajput.com/?user=nixrajput&theme=dark)](https://github.com/nixrajput/github-readme-streak-stats)
```

|     Theme      |                            Preview                            |
| :------------: | :-----------------------------------------------------------: |
|   `default`    |          ![default](https://i.imgur.com/IaTuYdS.png)          |
|     `dark`     |           ![dark](https://i.imgur.com/bUrsjlp.png)            |
| `highcontrast` |       ![highcontrast](https://i.imgur.com/ovrVrTY.png)        |
|  More themes!  | **🎨 [See a list of all available themes](./docs/themes.md)** |

**If you have come up with a new theme you'd like to share with others, please see [Issue #32](https://github.com/nixrajput/github-readme-streak-stats/issues/32) for more information on how to contribute.**

### 🗪 Locales

The following are the locales that have labels translated in Streak Stats. The `locale` query parameter accepts any ISO language or locale code, see [here](https://gist.github.com/nixrajput/f61147ba26bfcf7c3bf605af7d3382d5) for a list of valid locales. The locale provided will be used for the date format and number format even if translations are not yet available.

<!-- This section is automatically generated by the `translation-progress.php` script. -->
<!-- prettier-ignore-start -->
<!-- TRANSLATION_PROGRESS_START -->
<table><tbody><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L37"><code>en</code></a> - English<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L37"><img src="https://progress-bar.xyz/100" alt="English 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L47"><code>am</code></a> - አማርኛ<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L47"><img src="https://progress-bar.xyz/100" alt="አማርኛ 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L56"><code>ar</code></a> - العربية<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L56"><img src="https://progress-bar.xyz/100" alt="العربية 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L67"><code>as</code></a> - অসমীয়া<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L67"><img src="https://progress-bar.xyz/100" alt="অসমীয়া 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L84"><code>bho</code></a> - भोजपुरी<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L84"><img src="https://progress-bar.xyz/100" alt="भोजपुरी 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L93"><code>bn</code></a> - বাংলা<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L93"><img src="https://progress-bar.xyz/100" alt="বাংলা 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L102"><code>ca</code></a> - català<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L102"><img src="https://progress-bar.xyz/100" alt="català 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L111"><code>ceb</code></a> - Cebuano<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L111"><img src="https://progress-bar.xyz/100" alt="Cebuano 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L120"><code>da</code></a> - dansk<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L120"><img src="https://progress-bar.xyz/100" alt="dansk 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L129"><code>de</code></a> - Deutsch<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L129"><img src="https://progress-bar.xyz/100" alt="Deutsch 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L138"><code>el</code></a> - Ελληνικά<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L138"><img src="https://progress-bar.xyz/100" alt="Ελληνικά 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L147"><code>es</code></a> - español<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L147"><img src="https://progress-bar.xyz/100" alt="español 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L156"><code>et</code></a> - eesti<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L156"><img src="https://progress-bar.xyz/100" alt="eesti 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L165"><code>fa</code></a> - فارسی<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L165"><img src="https://progress-bar.xyz/100" alt="فارسی 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L176"><code>fi</code></a> - suomi<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L176"><img src="https://progress-bar.xyz/100" alt="suomi 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L185"><code>fil</code></a> - Filipino<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L185"><img src="https://progress-bar.xyz/100" alt="Filipino 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L194"><code>fr</code></a> - français<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L194"><img src="https://progress-bar.xyz/100" alt="français 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L203"><code>gu</code></a> - ગુજરાતી<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L203"><img src="https://progress-bar.xyz/100" alt="ગુજરાતી 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L212"><code>he</code></a> - עברית<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L212"><img src="https://progress-bar.xyz/100" alt="עברית 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L222"><code>hi</code></a> - हिन्दी<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L222"><img src="https://progress-bar.xyz/100" alt="हिन्दी 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L239"><code>hu</code></a> - magyar<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L239"><img src="https://progress-bar.xyz/100" alt="magyar 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L256"><code>id</code></a> - Indonesia<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L256"><img src="https://progress-bar.xyz/100" alt="Indonesia 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L265"><code>it</code></a> - italiano<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L265"><img src="https://progress-bar.xyz/100" alt="italiano 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L274"><code>ja</code></a> - 日本語<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L274"><img src="https://progress-bar.xyz/100" alt="日本語 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L285"><code>jv</code></a> - Jawa<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L285"><img src="https://progress-bar.xyz/100" alt="Jawa 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L294"><code>kk</code></a> - қазақ тілі<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L294"><img src="https://progress-bar.xyz/100" alt="қазақ тілі 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L303"><code>kn</code></a> - ಕನ್ನಡ<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L303"><img src="https://progress-bar.xyz/100" alt="ಕನ್ನಡ 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L312"><code>ko</code></a> - 한국어<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L312"><img src="https://progress-bar.xyz/100" alt="한국어 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L321"><code>mai</code></a> - मैथिली<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L321"><img src="https://progress-bar.xyz/100" alt="मैथिली 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L330"><code>mal</code></a> - മലയാളം<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L330"><img src="https://progress-bar.xyz/100" alt="മലയാളം 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L340"><code>mi</code></a> - Māori<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L340"><img src="https://progress-bar.xyz/100" alt="Māori 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L349"><code>mr</code></a> - मराठी<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L349"><img src="https://progress-bar.xyz/100" alt="मराठी 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L358"><code>ms</code></a> - Melayu<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L358"><img src="https://progress-bar.xyz/100" alt="Melayu 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L367"><code>ms_ID</code></a> - Melayu (Indonesia)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L367"><img src="https://progress-bar.xyz/100" alt="Melayu (Indonesia) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L376"><code>my</code></a> - မြန်မာ<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L376"><img src="https://progress-bar.xyz/100" alt="မြန်မာ 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L385"><code>ne</code></a> - नेपाली<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L385"><img src="https://progress-bar.xyz/100" alt="नेपाली 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L394"><code>nl</code></a> - Nederlands<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L394"><img src="https://progress-bar.xyz/100" alt="Nederlands 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L403"><code>no</code></a> - norsk<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L403"><img src="https://progress-bar.xyz/100" alt="norsk 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L412"><code>pa</code></a> - ਪੰਜਾਬੀ<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L412"><img src="https://progress-bar.xyz/100" alt="ਪੰਜਾਬੀ 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L421"><code>pl</code></a> - polski<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L421"><img src="https://progress-bar.xyz/100" alt="polski 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L430"><code>ps</code></a> - پښتو<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L430"><img src="https://progress-bar.xyz/100" alt="پښتو 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L441"><code>pt</code></a> - português<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L441"><img src="https://progress-bar.xyz/100" alt="português 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L450"><code>pt_BR</code></a> - português (Brasil)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L450"><img src="https://progress-bar.xyz/100" alt="português (Brasil) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L459"><code>ro</code></a> - română<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L459"><img src="https://progress-bar.xyz/100" alt="română 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L468"><code>ru</code></a> - русский<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L468"><img src="https://progress-bar.xyz/100" alt="русский 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L485"><code>sa</code></a> - संस्कृत भाषा<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L485"><img src="https://progress-bar.xyz/100" alt="संस्कृत भाषा 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L494"><code>sd_PK</code></a> - سنڌي (پاڪستان)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L494"><img src="https://progress-bar.xyz/100" alt="سنڌي (پاڪستان) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L506"><code>sr_Cyrl</code></a> - српски (ћирилица)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L506"><img src="https://progress-bar.xyz/100" alt="српски (ћирилица) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L515"><code>sr_Latn</code></a> - srpski (latinica)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L515"><img src="https://progress-bar.xyz/100" alt="srpski (latinica) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L524"><code>su</code></a> - Basa Sunda<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L524"><img src="https://progress-bar.xyz/100" alt="Basa Sunda 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L533"><code>sv</code></a> - svenska<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L533"><img src="https://progress-bar.xyz/100" alt="svenska 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L542"><code>sw</code></a> - Kiswahili<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L542"><img src="https://progress-bar.xyz/100" alt="Kiswahili 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L551"><code>ta</code></a> - தமிழ்<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L551"><img src="https://progress-bar.xyz/100" alt="தமிழ் 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L560"><code>tcy</code></a> - Tulu<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L560"><img src="https://progress-bar.xyz/100" alt="Tulu 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L569"><code>te</code></a> - తెలుగు<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L569"><img src="https://progress-bar.xyz/100" alt="తెలుగు 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L578"><code>th</code></a> - ไทย<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L578"><img src="https://progress-bar.xyz/100" alt="ไทย 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L587"><code>tr</code></a> - Türkçe<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L587"><img src="https://progress-bar.xyz/100" alt="Türkçe 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L596"><code>uk</code></a> - українська<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L596"><img src="https://progress-bar.xyz/100" alt="українська 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L605"><code>ur_PK</code></a> - اردو (پاکستان)<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L605"><img src="https://progress-bar.xyz/100" alt="اردو (پاکستان) 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L616"><code>vi</code></a> - Tiếng Việt<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L616"><img src="https://progress-bar.xyz/100" alt="Tiếng Việt 100%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L625"><code>yo</code></a> - Èdè Yorùbá<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L625"><img src="https://progress-bar.xyz/100" alt="Èdè Yorùbá 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L635"><code>zh_Hans</code></a> - 中文（简体）<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L635"><img src="https://progress-bar.xyz/100" alt="中文（简体） 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L645"><code>zh_Hant</code></a> - 中文（繁體）<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L645"><img src="https://progress-bar.xyz/100" alt="中文（繁體） 100%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L76"><code>bg</code></a> - български<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L76"><img src="https://progress-bar.xyz/86" alt="български 86%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L231"><code>ht</code></a> - créole haïtien<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L231"><img src="https://progress-bar.xyz/86" alt="créole haïtien 86%"></a></td></tr><tr><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L248"><code>hy</code></a> - հայերեն<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L248"><img src="https://progress-bar.xyz/86" alt="հայերեն 86%"></a></td><td><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L477"><code>rw</code></a> - Kinyarwanda<br /><a href="https://github.com/nixrajput/github-readme-streak-stats/blob/main/api/translations.php#L477"><img src="https://progress-bar.xyz/86" alt="Kinyarwanda 86%"></a></td><td></td><td></td><td></td></tr></tbody></table>
<!-- TRANSLATION_PROGRESS_END -->
<!-- prettier-ignore-end -->

**If you would like to help translate the Streak Stats cards, please see [Issue #236](https://github.com/nixrajput/github-readme-streak-stats/issues/236) for more information.**

### 📅 Date Formats

If `date_format` is not provided or is empty, the PHP Intl library is used to determine the date format based on the locale specified in the `locale` query parameter.

A custom date format can be specified by passing a string to the `date_format` parameter.

The required format is to use format string characters from [PHP's date function](https://www.php.net/manual/en/datetime.format.php) with brackets around the part representing the year.

When the contribution year is equal to the current year, the characters in brackets will be omitted.

**Examples:**

|     Date Format     |                                     Result                                      |
| :-----------------: | :-----------------------------------------------------------------------------: |
| <pre>d F[, Y]</pre> | <pre>"2020-04-14" => "14 April, 2020"<br/><br/>"2024-04-14" => "14 April"</pre> |
|  <pre>j/n/Y</pre>   |   <pre>"2020-04-14" => "14/4/2020"<br/><br/>"2024-04-14" => "14/4/2024"</pre>   |
| <pre>[Y.]n.j</pre>  |     <pre>"2020-04-14" => "2020.4.14"<br/><br/>"2024-04-14" => "4.14"</pre>      |
| <pre>M j[, Y]</pre> |   <pre>"2020-04-14" => "Apr 14, 2020"<br/><br/>"2024-04-14" => "Apr 14"</pre>   |

### Example

```md
[![GitHub Streak](https://github-readme-streak-stats.nixrajput.com/?user=nixrajput&currStreakNum=2FD3EB&fire=pink&sideLabels=F00&date_format=[Y.]n.j)](https://github.com/nixrajput/github-readme-streak-stats)
```

## ℹ️ How these stats are calculated

This tool uses the contribution graphs on your GitHub profile to calculate which days you have contributed.

To include contributions in private repositories, turn on the setting for "Private contributions" from the dropdown menu above the contribution graph on your profile page.

Contributions include commits, pull requests, and issues that you create in standalone repositories.

The longest streak is the highest number of consecutive days on which you have made at least one contribution.

The current streak is the number of consecutive days ending with the current day on which you have made at least one contribution. If you have made a contribution today, it will be counted towards the current streak, however, if you have not made a contribution today, the streak will only count days before today so that your streak will not be zero.

> [!NOTE]
> You may need to wait up to 24 hours for new contributions to show up ([Learn how contributions are counted](https://docs.github.com/articles/why-are-my-contributions-not-showing-up-on-my-profile))

## 🛠 Local development

Requires PHP 8.2+ and Composer.

```bash
composer install
cp .env.example .env      # set TOKEN to a GitHub PAT (no scopes needed for public data)
php -S localhost:8000 -t api
```

Run the test suite with `composer test`.

## 🚀 Deployment

Deployed to Vercel from this repo's `main` branch. `vercel.json` routes every request
to `api/index.php` on the `vercel-php` runtime. The other files under `api/` are libraries
it includes, not endpoints, so they are routed to the 404 page rather than left reachable
as empty responses. A sync that adds a library file needs adding to that rule.

| Environment variable | Purpose |
| :------------------- | :------ |
| `TOKEN`              | GitHub PAT used for the contributions GraphQL query. No scopes required for public data. |
| `WHITELIST`          | Comma-separated usernames allowed to use this instance. Unset leaves it open to everyone. |
| `DISABLE_CACHE`      | Set to `true` to bypass the response cache. Leave unset; disabling it invites rate limits. |

> [!IMPORTANT]
> Set a long expiry on the PAT. An expired token is the single most common cause of this
> card breaking, and it fails as a rendered "Failed to retrieve contributions" SVG rather
> than an obvious error.

## Contributing

Contributions are welcome. Fork, branch, and open a PR. Bugs and ideas go to [Issues][issues]; questions to [Discussions][discussions].

## Contributors

Thanks to everyone who has contributed to github-readme-streak-stats.

<a href="https://github.com/nixrajput/github-readme-streak-stats/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=nixrajput/github-readme-streak-stats" alt="Contributors" />
</a>

## License

Licensed under the **MIT** license - see [LICENSE](LICENSE).

Derived from [DenverCoder1/github-readme-streak-stats](https://github.com/DenverCoder1/github-readme-streak-stats) by Jonah Lawrence, used under the MIT License. The original
copyright notice is retained in [LICENSE](LICENSE). This repository is an independent
deployment and is not affiliated with or endorsed by the original author.

## Support the project

<div align="center">

github-readme-streak-stats is MIT licensed and free to use, always. If it earns a place on your profile, sponsorship is welcome.

<br />

<a href="https://github.com/sponsors/nixrajput">
  <img src="https://img.shields.io/badge/Sponsor_on_GitHub-EA4AAA?style=for-the-badge&logo=githubsponsors&logoColor=white" alt="GitHub Sponsors" />
</a>
<a href="https://ko-fi.com/nixrajput">
  <img src="https://img.shields.io/badge/Ko--fi-FF5E5B?style=for-the-badge&logo=kofi&logoColor=white" alt="Ko-fi" />
</a>
<a href="https://www.buymeacoffee.com/nixrajput">
  <img src="https://img.shields.io/badge/Buy_Me_a_Coffee-FFDD00?style=for-the-badge&logo=buymeacoffee&logoColor=black" alt="Buy Me a Coffee" />
</a>

</div>

## Connect

<div align="center">

**Nikhil Rajput**

<a href="https://github.com/nixrajput"><img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" /></a>
<a href="https://linkedin.com/in/nixrajput"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white" alt="LinkedIn" /></a>
<a href="https://x.com/nixrajput"><img src="https://img.shields.io/badge/X-000000?style=for-the-badge&logo=x&logoColor=white" alt="X" /></a>
<a href="https://instagram.com/nixrajput"><img src="https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="Instagram" /></a>
<a href="https://telegram.me/nixrajput"><img src="https://img.shields.io/badge/Telegram-26A5E4?style=for-the-badge&logo=telegram&logoColor=white" alt="Telegram" /></a>
<a href="mailto:nkr.nikhil.nkr@gmail.com"><img src="https://img.shields.io/badge/Email-EA4335?style=for-the-badge&logo=gmail&logoColor=white" alt="Email" /></a>

</div>

[repo]: https://github.com/nixrajput/github-readme-streak-stats
[issues]: https://github.com/nixrajput/github-readme-streak-stats/issues
[pulls]: https://github.com/nixrajput/github-readme-streak-stats/pulls
[discussions]: https://github.com/nixrajput/github-readme-streak-stats/discussions
[contributors]: https://github.com/nixrajput/github-readme-streak-stats/graphs/contributors
[license]: https://github.com/nixrajput/github-readme-streak-stats/blob/main/LICENSE
