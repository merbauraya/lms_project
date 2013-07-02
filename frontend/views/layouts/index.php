<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Hebo! - Responsive HTML5 Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Simpson Moyo - Webapplicationthemes.com">
	
	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	
    <!-- the styles 
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css"> -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Pontano+Sans'>
    
    <link rel="stylesheet" type="text/css" href="css/template.css">   
    <link rel="stylesheet" type="text/css" href="css/style1.css" />

   
    <!--style switcher --> 
    <script type="text/javascript" src="js/styleswitcher.js"></script>
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    

    <!-- The fav and touch icons -->
    <link rel="shortcut icon" href="img/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
  </head>

<body>
<section id="header">
<!-- Include the header bar -->
    <?php include_once('header.php');?>
<!-- /.container -->  
</section><!-- /#header -->
 
<section id="navigation-main">   
	<!-- get page from url -->
    <?php
    	if(isset($_GET['page']))
		{
			$page = $_GET['page'];	
		}else
		{
			$page = '';	
		}
	
	?>
    <!-- Include the navigation bar -->
   <?php include_once('navigation.php');?>
</section>
    
<section id="bottom" class="">
    <div class="container bottom"> 
    	<div class="row-fluid ">
            <div class="span3">
            	<h5>About us</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                
            </div><!-- /span3-->
            
            <div class="span3">
            	<h5>Blog roll</h5>
            	<ul class="list-blog-roll">
                    <li>
                    	<a href="#" title="Example blog article">Understanding CSS</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">40 Free icons</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">Search engine optimisation</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">Intermarket guide pt. 1</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">Intermarket guide pt. 2</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">Intermarket guide pt. 3</a>	
                    </li>
                    <li>
                    	<a href="#" title="Example blog article">CSS3 IE hacks</a>	
                    </li>
                </ul>
            	
            </div><!-- /span3-->
            
            <div class="span3">
            	<h5>Twitter feed</h5>
            	<p>
                    Cool CSS tutorial
                    <br/>
                    <a href="#">http://t.co/Xdert</a>
                    <br/>
                    <span>about 1 hour ago</span>
                </p>
                <p>
                    Everything to know about HTML5
                    <br/>
                    <a href="#">http://t.co/Xdert</a>
                    <br/>
                    <span>about 7 hours ago</span>
                </p>
                <p>
                    Learn PHP in 3 days
                    <br/>
                    <a href="#">http://t.co/Xdert</a>
                    <br/>
                    <span>about 9 hours ago</span>
                </p>
            </div><!-- /span3-->
            
            <div class="span3">
            	<h5>Contact us</h5>
                <p>
                    795 Folsom Ave, Suite 600<br/>
                    San Francisco, CA 94107<br/>
                    P: (123) 456-7890<br/>
                    E: first.last@gmail.com<br/>
                
                </p>
                <br>
                <h5>Follow us</h5>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Themeforest</a></li>
                
                </ul>
            </div><!-- /span3-->
        </div><!-- /row-fluid -->
        </div><!-- /container-->
</section><!-- /bottom-->

<footer>
    <div class="footer">
        <div class="container">
        	Copyright &copy; 2012. Designed by webapplicationthemes.com - High quality HTML Theme
        </div>
	</div>
</footer>

  </body>
</html>
