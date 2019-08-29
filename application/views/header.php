<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta property="fb:app_id" content="492334204146422">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="<?php echo ( isset($profile_title) ? $profile_title : 'propertyfinder.com'); ?>">
    <meta name="description" content="<?php echo ( isset($profile_description) ? $profile_description : ''); ?>">
    <meta name="author" content="">
    <script src="<?php echo site_url(); ?>assets/js/head.load.min.js"></script>
    <link href="<?php echo site_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo site_url(); ?>assets/css/propertyfinder.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php echo site_url(); ?>favicon.ico">
</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="brand" href="<?php echo site_url(); ?>"><strong>propertyfinder.com</strong></a>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li class="dropdown <?php echo (isset($menu['properties']) ? 'active' : ''); ?>">
                            <a id="pop-prop" class="dropdown-toggle" role="button" data-toggle="dropdown" href="<?php echo site_url('properties'); ?>">Properties</a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="pop-prop">
                                <li class="dropdown-submenu">
                                    <a href="<?php echo site_url('properties/residential'); ?>" tabindex="-1">Residential</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('properties/condominiums'); ?>">Condominiums</a></li>
                                        <li><a href="<?php echo site_url('properties/house-and-lots'); ?>">House and Lots</a></li>
                                        <li><a href="<?php echo site_url('properties/apartments'); ?>">Apartments</a></li>
                                        <li><a href="<?php echo site_url('properties/HDB'); ?>">HDB</a></li>
                                        <li><a href="<?php echo site_url('properties/boarding-houses'); ?>">Boarding Houses</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="<?php echo site_url('properties/commercial'); ?>" tabindex="-1">Commercial</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('properties/offices'); ?>">Offices</a></li>
                                        <li><a href="<?php echo site_url('properties/SOHO'); ?>">SOHO</a></li>
                                        <li><a href="<?php echo site_url('properties/retails'); ?>">Retail Shops</a></li>
                                        <li><a href="<?php echo site_url('properties/industrials'); ?>">Industrials</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="<?php echo site_url('properties/land'); ?>" tabindex="-1">Land</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('properties/land-only'); ?>">Land only</a></li>
                                        <li><a href="<?php echo site_url('properties/land-with-structure'); ?>">Land with structure</a></li>
                                        <li><a href="<?php echo site_url('properties/farms'); ?>">Farms</a></li>
                                        <li><a href="<?php echo site_url('properties/beach'); ?>">Beach</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="<?php echo site_url('properties/hotels-resorts'); ?>" tabindex="-1">Hotels/Resorts</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('properties/hotels'); ?>">Hotels</a></li>
                                        <li><a href="<?php echo site_url('properties/resorts'); ?>">Resorts</a></li>
                                        <li><a href="<?php echo site_url('properties/pension-inns'); ?>">Pension Inns</a></li>
                                        <li><a href="<?php echo site_url('properties/convention-centers'); ?>">Convention Centers</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo (isset($menu['agents']) ? 'active' : ''); ?>">
                            <a href="<?php echo site_url('agents'); ?>">Agents</a>
                        </li>
                        <li class="<?php echo (isset($menu['companies']) ? 'active' : ''); ?>">
                            <a href="<?php echo site_url('companies'); ?>">Companies</a>
                        </li>
                        <li class="<?php echo (isset($menu['map']) ? 'active' : ''); ?>">
                            <a href="<?php echo site_url('map'); ?>">Map</a>
                        </li>
                        <li class="dropdown <?php echo (isset($menu['wiki']) ? 'active' : ''); ?>">
                            <a id="pop-wiki" class="dropdown-toggle" role="button" data-toggle="dropdown" href="<?php echo site_url('wiki'); ?>">Help</a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="pop-wiki">
                                <li><a href="<?php echo site_url('wiki/about-propertyfinder'); ?>">What is propertyfinder</a></li>
                                <li><a href="<?php echo site_url('wiki/faq'); ?>">FAQ</a></li>
                            </ul>
                        </li>
                        <?php if(!$userlogin) { ?>
                        <li class="join"><a href="<?php echo site_url('register'); ?>"><strong>JOIN</strong> - It's Free!</a></li>
                        <?php } ?>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="dropdown <?php echo (isset($menu['selections']) ? 'active' : ''); ?>">
                            <a id="popme" class="dropdown-toggle" role="button" data-toggle="dropdown" href="<?php echo site_url('selections'); ?>">My Selections</a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="popme">
                                <li><a href="<?php echo site_url('comparisons'); ?>">My Comparisons</a></li>
                                <li><a href="<?php echo site_url('shortlist'); ?>">My Shortlist</a></li>
                                <li><a href="<?php echo site_url('recent_views'); ?>">Recent Views</a></li>
                            </ul>
                        </li>
                        <?php if(!$userlogin) { ?>
                        <li class="dropdown">
                            <a href="<?php echo site_url('login'); ?>" class="dropdown-toggle" data-toggle="dropdown">Login</a>
                            <div class="dropdown-menu mini-login">
                                <form action="<?php echo site_url('login'); ?>" method="post" accept-charset="UTF-8">
                                    <input type="text" id="userlogin" name="userlogin" class="input-large" maxlength="300" placeholder="Email Address" />
                                    <input type="password" id="userpass" name="userpass" class="input-large" maxlength="30" placeholder="Password" />
                                    <input type="checkbox" id="userremember" name="userremember" value="1" />
                                    <input type="hidden" name="pg" value="<?php echo $currpg; ?>" />
                                    <label class="string optional" for="userremember"> Remember me</label>
                                    <input class="btn btn-primary mini-login-btn" style="width: 100%;" type="submit" name="login" value="Login" />
                                    <div class="social-login" align="center">
                                        <a href="#" class="btn-fb-login facebook-color"><i class="icon2-facebook-sign"></i> Facebook</a> | <a href="#" class="btn-twitter-login twitter-color"><i class="icon2-twitter-sign"></i> Twitter</a>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <?php } else { ?>
                        <li class="dropdown <?php echo (isset($menu['notifications']) ? 'active' : ''); ?>">
                            <a style="padding:10px 5px;position:relative;" role="button" href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/' . url_title($userfullname) . '/notifications'); ?>">
                                <i class="icon-bell" style="opacity:.80;"></i>
                                <div class="notifications"></div>
                            </a>
                        </li>
                        <li class="dropdown <?php echo (isset($menu['user']) ? 'active' : ''); ?>">
                            <a id="popaccount" class="dropdown-toggle" role="button" data-toggle="dropdown" href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/' . url_title($userfullname) . '/' . url_title($usercode)); ?>">
                                <img src="<?php echo site_url(). ( !empty($userpic) ? ( $usertype == USERTYPE_COMPANY ? 'realties/' : 'profiles/' ) . $userpic : 'assets/img/' . ( $usertype == USERTYPE_COMPANY ? 'company50.png' : 'agent50.png' ) ); ?>" class="user-menu" />
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="popaccount">
                                <li><a href="<?php echo site_url('property/post'); ?>">Post a Property</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/my-properties'); ?>">My Properties</a></li>
                                <li><a href="<?php echo site_url('account'); ?>">My Account</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('messages'); ?>">Inbox</a></li>
                                <li><a href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/' . url_title($userfullname) . '/' . url_title($usercode)); ?>">View Profile</a></li>
                                <li><a href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/edit/' . url_title($userfullname) . '/' . url_title($usercode)); ?>">Edit Profile</a></li>
                                <li><a href="<?php echo site_url( ( $usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/password/' . url_title($userfullname) . '/' . url_title($usercode)); ?>">Change Password</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        