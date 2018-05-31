<?php
$system_phone    =	$this->db->get_where('settings' , array('type'=>'phone'))->row()->description;
?>

<header>
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <a href="tel:1800-234-2845" class="call-us"><i class="fa fa-phone"></i> <?=$system_phone?></a>
                </div>
                <div class="col-sm-6">
                    <div class="dropdown">
                        <button class="btn btn-xs" type="button" id="select-lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-globe"></i> Nigeria
                        </button>

                    </div>
                    <form class="search form-inline">
                        <input type="text" class="form-control" placeholder="Start typing...">
                        <button class="btn-search" type="submit"><i class="fa fa-search fa-fw"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false">
                    <span class="sr-only">Toggle Menu</span>
                    <span>Menu</span>
                </button>
                <a class="navbar-brand" href="<?=base_url();?>"><img src="uploads/logo.png" height="60" alt="" /></a>
            </div>

            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?php if ($navigation == 'home') echo 'active'; ?>"><a href="<?=base_url();?>">Home</a>
                    </li>

                    <li class="<?php if ($navigation == 'about') echo 'active'; ?>"><a href="#">About</a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('index.php?about/brief-history')?>">Brief History</a></li>
                            <li><a href="<?=base_url('index.php?about/admissions');?>">Admission Process</a></li>
                            <li><a href="#">Code of Conduct</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ($navigation == 'noticeboard') echo 'active'; ?>"><a href="<?=base_url('index.php?noticeboard');?>">Noticeboard</a>
                    </li>

                    <li class="<?php if ($navigation == 'events') echo 'active'; ?>"><a href="<?=base_url('index.php?events');?>">Events</a>
                    </li>

                    <li class="<?php if ($navigation == 'admission') echo 'active'; ?>"><a href="<?=base_url('index.php?about/admissions');?>">Admission</a>
                    </li>

                    <li class="<?php if ($navigation == 'contact_us') echo 'active'; ?>"><a href="#">Contact</a>
                    </li>

                    <li><a href="<?=base_url('index.php?login');?>">Login</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
    