<style>
.about-text{ 
	display: block;
	height: 40px;
	min-height: 40px; 
}
h1 {
    color: #333333;
    text-shadow: 1px 1px 1px #FFFFFF; 
    font-size: 2.8em;
    font-weight: 200;
    line-height: 1.2em;
    margin: 0.2em 200px 0 0;
}
h2 .nav-tab {
    color: #21759B;
}
h2 .nav-tab-active {
    color: #464646;
    text-shadow: 1px 1px 1px #FFFFFF;
}
hr{ 
	border-color: #EEEEEE;
	border-style: none none solid;
	border-width: 0 0 1px;
	margin: 2px 0 15px;
} 
.wsldiv { 
    margin: 25px 40px 0 20px; 
}
.wsldiv p{  
	line-height: 1.8em;
}
.wslgn{ 
    margin-left:20px;
}
.wslgn p{ 
	margin-left:20px;
}
.wslpre{ 
    font-size:14m;
	border:1px solid #E6DB55; 
	border-radius: 3px;
	padding:5px;
	width:650px;
}
ul {
    list-style: disc outside none;
}
</style>

<div class="wsldiv">

<h1>WordPress Social Login 1.2.4</h1>

<div class="about-text">Allow your visitors to comment and login with social networks such as Twitter, Facebook, Google, Yahoo and more. </div>

<h2 class="nav-tab-wrapper">
	&nbsp;
    <a class="nav-tab <?php if( $wslp == 1 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=1">Settings</a> 
    <a class="nav-tab <?php if( $wslp == 2 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=2">Customize</a>   
    <a class="nav-tab <?php if( $wslp == 3 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=3">Insights</a>   
    <a class="nav-tab <?php if( $wslp == 4 ) echo "nav-tab-active"; ?>" style="float:right" href="options-general.php?page=wordpress-social-login&wslp=4">Diagnostics</a>  
    <a class="nav-tab <?php if( $wslp == 5 ) echo "nav-tab-active"; ?>" style="float:right" href="options-general.php?page=wordpress-social-login&wslp=5">Help & Support</a> 
</h2>