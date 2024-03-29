<?php require_once('../lib/SessionHeader.php'); ?>
<?php require_once('HeaderForEverything.php'); ?>

    <!-- selects (this v=... is only for testing purposes! it prevents the browser from caching the css-->
    <link href="/css/select.css?v=<?=time();?>" rel="stylesheet" type="text/css">
    <!-- <script src="/js/select.js?v=<?=time();?>"></script>  -->
    <script src="/js/SelectBarContainer.js?v=<?=time();?>"></script>     
    <script src="/js/SelectBar.js?v=<?=time();?>"></script>     

    <script src="/js/ClassSwitcher.js?v=<?= time(); ?>"></script>     
    

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <!-- <link href="/css/style.css?v=<?=time();?>" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">For Honor</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li><a href="/Home">Home</a></li> -->
            <li><a href="/Fighter">Fighter</a></li>
            <li><a href="/Fight">Fight</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/User/Logout">Logout</a></li>
        </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">