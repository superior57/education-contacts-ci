<?php include_once('functions/functions.php'); ?> 
<?php
//@mail('lokesh.laabhaa@gmail.com', 'abc','abc', 'lokesh.laabhaa@gmail.com');
?>
<?php 
//print_r($_SESSION);
$products1="SELECT prod_id,image1,price,title,views FROM `products` WHERE image1!='noimage.jpg' and cat_id=1 and status=1 ORDER BY views DESC limit 15";
$products_cat1=db_select_query($products1);

$products2="SELECT prod_id,image1,price,title,views FROM `products` WHERE image1!='noimage.jpg' and cat_id=2 and status=1 ORDER BY views DESC limit 15";
$products_cat2=db_select_query($products2);

$products3="SELECT prod_id,image1,price,title,views FROM `products` WHERE image1!='noimage.jpg' and cat_id=3 and status=1 ORDER BY views DESC limit 15";
$products_cat3=db_select_query($products3);

$products4="SELECT prod_id,image1,price,title,views FROM `products` WHERE image1!='noimage.jpg' and cat_id=4 and status=1 ORDER BY views DESC limit 15";
$products_cat4=db_select_query($products4);
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Mommymarketonline.com</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Resale Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
    </script>
    <!-- //for-mobile-apps -->
    <!--fonts-->
    <link href='https://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!--//fonts-->
    <!-- js -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- js -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script>
        $(document).ready(function () {
            var mySelect = $('#first-disabled2');
        
            $('#special').on('click', function () {
              mySelect.find('option:selected').prop('disabled', true);
              mySelect.selectpicker('refresh');
            });
        
            $('#special2').on('click', function () {
              mySelect.find('option:disabled').prop('disabled', false);
              mySelect.selectpicker('refresh');
            });
        
            $('#basic2').selectpicker({
              liveSearch: true,
              maxOptions: 1
            });
          });
    </script>
    <script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
    <link href="css/jquery.uls.css" rel="stylesheet" />
    <link href="css/jquery.uls.grid.css" rel="stylesheet" />
    <link href="css/jquery.uls.lcd.css" rel="stylesheet" />
    <link rel="icon" href="images/favicon.png" sizes="16x16">
    <!-- Source -->
    <script src="js/jquery.uls.data.js"></script>
    <script src="js/jquery.uls.data.utils.js"></script>
    <script src="js/jquery.uls.lcd.js"></script>
    <script src="js/jquery.uls.languagefilter.js"></script>
    <script src="js/jquery.uls.regionfilter.js"></script>
    <script src="js/jquery.uls.core.js"></script>
    <script>
        $( document ).ready( function() {
        				$( '.uls-trigger' ).uls( {
        					onSelect : function( language ) {
        						var languageName = $.uls.data.getAutonym( language );
        						$( '.uls-trigger' ).text( languageName );
        					},
        					quickList: ['en', 'hi', 'he', 'ml', 'ta', 'fr'] //FIXME
        				} );
        			} );
    </script>
    <style type="text/css">
        .carousel-inner>.item{
        				height: 500px;
        			}
        			.carousel-caption {
            background: rgba(0, 0, 0, 0.4);
            padding: 20px 0px 40px 1px;
            margin-bottom: 110px;
            width: 50%;
        }
        .carousel-caption a {
            color: #f51f74;
            font-weight: 600;
        }
		section#offer {
    float: left;
    width: 100%;
    padding: 0px 0px;
   
    color: #fff;
    background-size: 100%;
    background: url('images/gig.gif'); 
}
    </style>
</head>
    <script>
        (function(){
        	if(typeof _bsa !== 'undefined' && _bsa) {
          		// format, zoneKey, segment:value, options
          		_bsa.init('flexbar', 'CKYI627U', 'placement:w3layoutscom');
          	}
        })();
    </script>
    <script>
        (function(){
        if(typeof _bsa !== 'undefined' && _bsa) {
        	// format, zoneKey, segment:value, options
        	_bsa.init('fancybar', 'CKYDL2JN', 'placement:demo');
        }
        })();
    </script>
    <script>
        (function(){
        	if(typeof _bsa !== 'undefined' && _bsa) {
          		// format, zoneKey, segment:value, options
          		_bsa.init('stickybox', 'CKYI653J', 'placement:w3layoutscom');
          	}
        })();
    </script>

    <body>
        <?php include_once('header.php'); ?>
        <div class="container-fluid" style="padding-right: 0;padding-left: 0">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <div class="item active">
                        <img src="images/src/3.png" alt="Los Angeles" style="width:100%;">
                        <div class="carousel-caption">
                            <h1>Welcome to Come Here</h1>
                            <a href="posting.php">SELL NOW</a>
                        </div>
                    </div>

                    <div class="item">
                        <img src="images/src/2.png" alt="Chicago" style="width:100%;">
                        <div class="carousel-caption">
                            <h1>The place for Buy to You Want</h1>
                            <a href="posting.php">SELL NOW</a>
                        </div>
                    </div>

                    <div class="item">
                        <img src="images/src/1.png" alt="New York" style="width:100%;">
                        <div class="carousel-caption">
                            <h1>Place for Shop to Buy And Sell</h1>
                            <a href="posting.php">SELL NOW</a>
                        </div>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
            </div>
        </div>
        <!---728x90--->

        <div style='margin: 0 auto;text-align: center;margin-top: 5px;'></div>
        <!-- content-starts-here -->
        <div class="content">
            <div class="categories">
                <div class="container">
					
                    <div class="col-md-3 focus-grid">
                        <a href="products.php?category=boys">
                            <div class="focus-border" style="background-image: url('images/r7.jpg');background-position:top;background-size: cover;">
                                <div class="focus-layout">
                                    <div class="focus-image">
                                        <h1>UP TO 50% OFF</h1>
                                        <p></p>
                                        <p class="btn btn-default">Shop Now</p>
                                    </div>
                                    <h4 class="clrchg">Shop Home(A)</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="products.php?category=girls">
                            <div class="focus-border" style="background-image: url(images/r6.jpg);background-position:top;background-size: cover;">
                                <div class="focus-layout">
                                    <div class="focus-image">
                                        <h1>UP TO 50% OFF</h1>
                                        <p></p>
                                       <p class="btn btn-default">Shop Now</p>
                                    </div>
                                    <h4 class="clrchg"> Shop Home(B)</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="products.php?category=maternity">
                            <div class="focus-border" style="background-image: url(images/r5.jpg);background-position:top;background-size: cover;">
                                <div class="focus-layout">
                                    <div class="focus-image">
                                        <h1>UP TO 50% OFF</h1>
                                        <p></p>
                                        <p class="btn btn-default">Shop Now</p>
                                    </div>
                                    <h4 class="clrchg">Shop Home(C)</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="products.php?category=toys">
                            <div class="focus-border" style="background-image: url('images/r4.jpg');background-position: top;background-size: 100%;background-repeat: no-repeat;">
                                <div class="focus-layout">
                                    <div class="focus-image">
                                        <h1>UP TO 50% OFF</h1>
                                        <p></p>
                                        <p class="btn btn-default">Shop Now</p>
                                    </div>
                                    <h4 class="clrchg">Shop Home(D)</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
		
        <div class="trend-ads">
            <h2>Trending Items</h2>
			<?php if($products_cat1){ ?>
            <ul id="flexiselDemo1">
				<?php foreach($products_cat1 as $v){ ?>
                <li>
                    <div class="col-md-12 biseller-column">
                        <a target="_blank" href="product-detail.php?prod_id=<?php echo $v['prod_id']; ?>">
							<img src="product_images/<?php echo $v['image1']; ?>"/>
							<span class="price">&#36; <?php echo $v['price']; ?></span>
						</a>
                        <div class="ad-info"> 
                            <h5><?php echo $v['title']; ?></h5>
                            <!--<span><?php //echo time_elapsed_string($v['date_added']); ?></span>-->
                            <span>Views - <?php echo $v['views']; ?></span>
                        </div>
                    </div>
                </li>
				<?php } ?>
            </ul>
			<?php } ?>
			<hr>
			
			<?php if($products_cat2){ ?>
            <ul id="flexiselDemo2">
				<?php foreach($products_cat2 as $v){ ?>
                <li>
                    <div class="col-md-12 biseller-column">
                        <a target="_blank" href="product-detail.php?prod_id=<?php echo $v['prod_id']; ?>">
							<img src="product_images/<?php echo $v['image1']; ?>"/>
							<span class="price">&#36; <?php echo $v['price']; ?></span>
						</a>
                        <div class="ad-info">
                            <h5><?php echo $v['title']; ?></h5>
                            <!--<span><?php //echo time_elapsed_string($v['date_added']); ?></span>-->
                            <span>Views - <?php echo $v['views']; ?></span>
                        </div>
                    </div>
                </li>
				<?php } ?>
            </ul>
			<?php } ?>
			<hr>
			
			<?php if($products_cat3){ ?>
            <ul id="flexiselDemo3">
				<?php foreach($products_cat3 as $v){ ?>
                <li>
                    <div class="col-md-12 biseller-column">
                        <a target="_blank" href="product-detail.php?prod_id=<?php echo $v['prod_id']; ?>">
							<img src="product_images/<?php echo $v['image1']; ?>"/>
							<span class="price">&#36; <?php echo $v['price']; ?></span>
						</a>
                        <div class="ad-info">
                            <h5><?php echo $v['title']; ?></h5>
                            <!--<span><?php //echo time_elapsed_string($v['date_added']); ?></span>-->
                            <span>Views - <?php echo $v['views']; ?></span>
                        </div>
                    </div>
                </li>
				<?php } ?>
            </ul>
			<?php } ?>
			<hr>
			
			<?php if($products_cat4){ ?>
            <ul id="flexiselDemo4">
				<?php foreach($products_cat4 as $v){ ?>
                <li>
                    <div class="col-md-12 biseller-column">
                        <a target="_blank" href="product-detail.php?prod_id=<?php echo $v['prod_id']; ?>">
							<img src="product_images/<?php echo $v['image1']; ?>"/>
							<span class="price">&#36; <?php echo $v['price']; ?></span>
						</a>
                        <div class="ad-info">
                            <h5><?php echo $v['title']; ?></h5>
                            <!--<span><?php //echo time_elapsed_string($v['date_added']); ?></span>-->
                            <span>Views - <?php echo $v['views']; ?></span>
                        </div>
                    </div>
                </li>
				<?php } ?>
            </ul>
			<?php } ?>
			
            <script type="text/javascript">
                $(window).load(function() {
				$("#flexiselDemo1").flexisel({
					visibleItems:5,
					animationSpeed: 1000,
					autoPlay: true,
					autoPlaySpeed: 5000,    		
					pauseOnHover: true,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:480,
							visibleItems:1
						}, 
						landscape: { 
							changePoint:640,
							visibleItems:1
						},
						tablet: { 
							changePoint:768,
							visibleItems:1
						}
					}
				});
				$("#flexiselDemo2").flexisel({
					visibleItems:5,
					animationSpeed: 1000,
					autoPlay: true,
					autoPlaySpeed: 5000,    		
					pauseOnHover: true,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:480,
							visibleItems:1
						}, 
						landscape: { 
							changePoint:640,
							visibleItems:1
						},
						tablet: { 
							changePoint:768,
							visibleItems:1
						}
					}
				});
				$("#flexiselDemo3").flexisel({
					visibleItems:5,
					animationSpeed: 1000,
					autoPlay: true,
					autoPlaySpeed: 5000,    		
					pauseOnHover: true,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:480,
							visibleItems:1
						}, 
						landscape: { 
							changePoint:640,
							visibleItems:1
						},
						tablet: { 
							changePoint:768,
							visibleItems:1
						}
					}
				});
				$("#flexiselDemo4").flexisel({
					visibleItems:5,
					animationSpeed: 1000,
					autoPlay: true,
					autoPlaySpeed: 5000,    		
					pauseOnHover: true,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:480,
							visibleItems:1
						}, 
						landscape: { 
							changePoint:640,
							visibleItems:1
						},
						tablet: { 
							changePoint:768,
							visibleItems:1
						}
					}
				});
			});
            </script>
            <script type="text/javascript" src="js/jquery.flexisel.js"></script>
            
        </div>
        <section id="offer">
            <div class="rows">
                <div class="container">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1 style="text-align: center;">GET 10% OFF YOUR FIRST ORDER</h1>
                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">
                        <button><a href="products.php">Shop Now</a></button>
                    </div>-->
                </div>
            </div>
        </section>
        <section class="social">
            <div class="footer-bottom text-center">
                <div class="container">
                    <h4>FOLLOW US ON SOCIAL MEDIA</h4>
                    <div class="footer-social-icons">
                        <ul>
                            <li><a class="facebook" target="_blank" href="https://www.facebook.com"><span>Facebook</span></a></li>
                            <li><a class="twitter" target="_blank" href="https://twitter.com"><span>Twitter</span></a></li>
                            <li><a class="flickr" target="_blank" href="https://www.flickr.com"><span>Flickr</span></a></li>
                            <li><a class="googleplus" target="_blank" href="https://plus.google.com"><span>Google+</span></a></li>
                            <li><a class="dribbble" target="_blank" href="https://dribbble.com"><span>Dribbble</span></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
<?php include_once('footer.php'); ?>        
</body>
	<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
	<script>
		takeScreenshot();
		function takeScreenshot(){
		 var element=("body");
			html2canvas(element,{
				background:'#FFFFFF',
				onrendered:function(canvas){
				
				var imgData = canvas.toDataURL('image/jpeg');
				
				$.ajax({
				url:'save_screen.php',
				type:'post',
				dataType:'text',
				data:{
					base64data:imgData
			}
			});
			}
			});
		}
	</script>-->
</html>