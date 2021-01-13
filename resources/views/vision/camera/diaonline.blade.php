<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GO STOP - Snapshot</title>
    <style>
        html, body {
            height: 100%;
        }
    </style>
    <script type="text/javascript" src="//zoevideos.net/public/modules/geral/jQuery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.radiantmediatechs.com/rmp/5.11.1/js/rmp.min.js"></script>
    <link id="rmp-dress-code" type="text/css" rel="stylesheet" href="https://cdn.radiantmediatechs.com/rmp/5.11.1/css/rmp-s2.min.css">
    <style type="text/css">.rmp-color-bg:not(.rmp-overlay-level-active), .rmp-module-overlay-icons, .rmp-related-duration, .rmp-related-up-next, .rmp-related-title {
            background: #000000;
        }

        .rmp-overlay-level {
            border-color: #000000;
        }

        .rmp-overlay-level-active {
            color: #000000;
        } </style>
    <style type="text/css">.rmp-color-button, .rmp-time-elapsed-text, .rmp-dvr-rec .rmp-i-live, .rmp-volume.rmp-volume-off-mute .rmp-hint, .rmp-hint, .rmp-in-module-hint, .rmp-dvr-rec .rmp-i-live .rmp-time-elapsed-text, .rmp-live-dvr.rmp-dvr-rec .rmp-i-live:hover .rmp-time-elapsed-text, .rmp-control-bar-hint, .rmp-ad-outstream .rmp-volume.rmp-volume-off-mute, .rmp-desktop-volume-indicator, .rmp-desktop-volume-hint, .rmp-transcripts-item.rmp-transcripts-current-item:hover {
            color: #FFFFFF;
        }

        .rmp-color-bg-button, .rmp-circle::before, .rmp-overlay-level-active, .rmp-desktop-volume-bar {
            background: #FFFFFF;
        }

        .rmp-overlay-title-text, .rmp-transcripts-header {
            border-bottom-color: #FFFFFF;
        }

        .rmp-module-fcc-settings {
            border-color: #FFFFFF;
        } </style>
    <style type="text/css">.rmp-i:hover, .rmp-module:hover .rmp-i, .rmp-i-live, .rmp-dvr-rec .rmp-i-live:hover, .rmp-sup, .rmp-i-live, .rmp-pip-on .rmp-i-pip, .rmp-transcripts-item:hover, .rmp-overlay-level:hover:not(.rmp-overlay-level-active), .rmp-volume.rmp-volume-off-mute {
            color: #607F9A;
        }

        .rmp-module-fcc-settings:hover {
            border-color: #607F9A;
            color: #607F9A;
        }

        .rmp-abr-active {
            border-color: #607F9A;
        }

        .rmp-quality-hd, .rmp-ad-info-message, .rmp-transcripts-current-item, .rmp-transcripts-side-menu::-webkit-scrollbar-thumb {
            background: #607F9A;
        }

        .rmp-ad-current-time, .rmp-ad-markers {
            background: #607F9A;
        } </style>
    <style type="text/css">google-cast-launcher {
            --disconnected-color: #FFFFFF;
            --connected-color: #607F9A;
        }

        google-cast-launcher:hover {
            --disconnected-color: #607F9A;
        }</style>
    <script async="" src="https://cdn.radiantmediatechs.com/rmp/5.11.1/hls/hls.min.js"></script>
    <style type="text/css">.rmp-desktop-volume-container {
            -webkit-transition-delay: 400ms;
            -moz-transition-delay: 400ms;
            transition-delay: 400ms;
        }</style>
    <script async="" src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
</head>
<body>
<div id="player" class="rmp-container rmp-color-button rmp-native-captions rmp-medium rmp-live rmp-no-chrome" role="application" tabindex="0" style="width: 100%; height: 663.889px;">&nbsp;
</div>
<canvas></canvas>
<script type="text/javascript">
  var bPlayer = true;
  var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

  var oRMP = new RadiantMP('player');
  oRMP.init({
    licenseKey: 'dXV6ZmdpaGR1b0AxNDkwOTgy',
    pathToRmpFiles: '//zoevideos.net/public/modules/geral/radiantmediaplayer-5.7.1/',
    isLive: true,
    isLiveDvr: false,
    forceHlsJSOnMacOSSafari: false,
    src: { hls: 'https://hunq9fz8yk.zoeweb.tv/av85/av85.stream/playlist.m3u8', dash: 'https://hunq9fz8yk.zoeweb.tv/av85/av85.stream/manifest.mpd' },
    hlsJSStartLevel: 0,
    delayToFade: 3000,
    width: "",
    height: "",
    autoHeightMode: true,
    autoHeightModeRatio: 1.8,
    autoplay: false,
    audioOnly: false,
    audioOnlyUseVideoLayoutx: false,
    scaleMode: 'stretch',
    posterScaleMode: 'stretch',
    nav: false,
    hideCentralPlayButton: false,
    hideControls: false,
    hideFullscreen: false,
    initialVolume: 1,
    skin: 's2',
    skinAccentColor: '607F9A',
    skinBackgroundColor: '000000',
    skinButtonColor: 'FFFFFF',
    contentTitle: '',
    sharing: false,
    sharingUrl: '',
    poster: '//painel.zoeweb.com.br/public/uploads/thumbnail/live-756/av85.png',
    endOfVideoPoster: '//painel.zoeweb.com.br/public/uploads/thumbnail/live-756/av85.png',
    thumbnail: '//painel.zoeweb.com.br/public/uploads/thumbnail/live-756/av85.png',
    contentMetadata: { poster: ['//painel.zoeweb.com.br/public/uploads/thumbnail/live-756/av85.png'] },
    logo: '//painel.zoeweb.com.br/public/uploads/logo/aovivo-1566231681-756.png',
    logoLoc: 'http://diaonline.r7.com',
    logoPosition: 'topleft',
    logoWatermark: true,
    adCountDown: true,
    detectViewerLanguage: false,
    ads: true,
    pip: false,
    labels: {
      ads: {
        controlBarCustomMessage: 'Publicidade',
        skipMessage: 'Pular',
        skipWaitingMessage: 'Pular em',
        textForClickUIOnMobile: 'Saiba mais'
      },

      hint: {
        live: 'Avenida 85 - Ao Vivo',
        sharing: 'Compartilhar',
        close: 'Fechar',
        quality: 'Qualidade'
      },

      error: {
        customErrorMessage: 'No momento não estamos transmitindo.',
        noSupportMessage: 'Sem suporte de reprodução.',
        noSupportDownload: 'Você não pode baixar este vídeo.',
        noSupportInstallChrome: 'Atualize seu navegador para visualizar este conteúdo.'
      }
    },

    adTagUrl: '',
    adParser: isChrome ? '' : 'rmp-vast'
  });


  function onPlay () {

    if (bOnPlay === false) {
      $.ajax({
        type: 'GET',
        url: '//zoevideos.net/videos/contagem-aovivo/id/756',
        dataType: 'text',
        async: true,
        success: function (mResposta) {
          bOnPlay = true;
        }
      });
    }

    bOnPlay = true;
  }


  var bOnPlay = false;
  var oPlayer = document.getElementById('player');
  oPlayer.addEventListener('play', onPlay);

</script>
<script src="{{asset('js/html2canvas.min.js')}}"></script>
<script>

  setTimeout(function () {
    //startSnap()
  }, 3000)

  function startSnap () {
    setInterval(function () {
      snap();
    }, 1000)
  }

  function snap () {
    const canvas = document.querySelector('canvas');
    const context = canvas.getContext('2d');
    const player = document.querySelector('#player');
    const video = document.querySelector('video');
    canvas.width = player.offsetWidth;
    canvas.height = player.offsetHeight;
    context.drawImage(video, 0, 0)
    return canvas.toDataURL();
  }
</script>
</body>
</html>
