<style>
.about-text { 
    display: block;
    height: 34px;
    min-height: auto;
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
.wrap { 
    margin: 25px 40px 0 20px; 
}
</style>

<div class="wrap">

<h1>WordPress Social Login 2.1</h1>

<div class="about-text">Allow your visitors to comment and login with social networks such as Twitter, Facebook, Google, Yahoo and more. </div>

<h2 class="nav-tab-wrapper">
	&nbsp;
    <a class="nav-tab <?php if( $wslp == 4 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=4">Settings</a> 
    <a class="nav-tab <?php if( $wslp == 5 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=5">Customize</a>   
    <a class="nav-tab <?php if( $wslp == 6 ) echo "nav-tab-active"; ?>" href="options-general.php?page=wordpress-social-login&wslp=6">Insights</a>   
    <a class="nav-tab <?php if( $wslp == 3 ) echo "nav-tab-active"; ?>" style="float:right" href="options-general.php?page=wordpress-social-login&wslp=3">Diagnostics</a>  
    <a class="nav-tab <?php if( $wslp == 2 ) echo "nav-tab-active"; ?>" style="float:right" href="options-general.php?page=wordpress-social-login&wslp=2">Help & Support</a> 
</h2>