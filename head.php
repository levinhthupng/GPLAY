<?php require_once('config.php'); 
$t = time ();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$site['site_domain'];?><?=$site['site_favicon'];?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$site['site_domain'];?><?=$site['site_favicon'];?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$site['site_domain'];?><?=$site['site_favicon'];?>">
    <meta property="og:title" content="<?=$site['site_tenweb'];?>" />
    <meta property="og:image" content="<?=$site['site_domain'];?><?=$site['site_image'];?>" />
    <meta property="og:description" content="<?=$site['site_mota'];?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?=$site['site_tukhoa'];?>" />
    <meta name="description" content="<?=$site['site_mota'];?>" />
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="/vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="/vendors/styles/bootstrap-ics.css" />
    <link rel="stylesheet" type="text/css" href="/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/vendors/styles/style.css">
    <link rel="stylesheet" type="text/css" href="/src/plugins/jquery-steps/jquery.steps.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script src="/assets/cute/cute-alert.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/cute/cute-alert.css">
    <link rel="stylesheet" href="/style1.css" /> 
    <script src="/src/scripts/sweetalert.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
     crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-80C2LJ7R4D"></script>
    <meta name="facebook-domain-verification" content="4ig9xi04jnv3j82pil7de6a7x3mbo8" />
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-80C2LJ7R4D');
    </script>
     
    <style>
    .dropdown-menu.inner.show {
    min-width: unset !important;
    }
    #loading {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    ::-webkit-scrollbar-thumb {
        background: <?=$site['color'];
        ?>;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }

    .btn-primary {
        color: #fff;
        background-color: <?=$site['color'];
        ?>;
        border-color: <?=$site['color'];
        ?>;
    }

    .text-blue {
        color: <?=$site['color'];
        ?>;
    }
    
    .left {
        background-color: #262626;
        position: relative;
        padding-right: 0px;
        color: #ffffff;
    }
    body {
        font-family: 'JetBrains Mono', serif !important;
    }
    </style>

</head>