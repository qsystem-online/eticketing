<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<section class="content-header">
    <h1><?=lang("Dashboard")?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Menus") ?></a></li>
		<li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!--<h3 class="box-title title"><?=$title?></h3>-->
        </div>
    </div>
    <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Approval") ?></a></li>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{ttlNeedApproval}</h3>
                    <p><?=lang("Approval Request")?></p>
                </div>
                <div class="icon">			  
                    <i class="ion ion-compose"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/AR" class="small-box-footer">More info <i class="fa fa-pencil"></i></a>
            </div>
        </div>
    </div>
    <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("My Ticket Issued") ?></a></li>
    <div class="row">   
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{ttlIssuedApproved}</h3>
                    <p><?=lang("Ticket Issued Open")?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/I01" class="small-box-footer">More info <i class="fa fa-check" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{ttlIssuedAccepted}</h3>
                    <p><?= lang(" Ticket Issued Accepted")?></p>
                </div>
                <div class="icon">			  
                    <i class="fa fa-recycle"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/I02" class="small-box-footer">More info <i class="fa fa-recycle"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{ttlIssuedNeedRevision}</h3>
                    <p><?= lang("Need Revision")?></p>
                </div>
                <div class="icon">			  
                    <i class="ion ion-compose"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/I03" class="small-box-footer">More info <i class="fa fa-pencil"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{ttlIssuedCompleted}</h3>
                    <p><?=lang("Ticket Issued Completed")?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/I04" class="small-box-footer">More info <i class="fa fa-check" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("My Ticket Received") ?></a></li>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{ttlReceivedApproved}</h3>
                    <p><?=lang("Ticket Received Open")?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/R01" class="small-box-footer">More info <i class="fa fa-check" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{ttlReceivedAccepted}</h3>
                    <p><?= lang(" Ticket Received Accepted")?></p>
                </div>
                <div class="icon">			  
                    <i class="fa fa-recycle"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/R02" class="small-box-footer">More info <i class="fa fa-recycle"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{ttlReceivedNeedRevision}</h3>
                    <p><?= lang("Need Revision")?></p>
                </div>
                <div class="icon">			  
                    <i class="ion ion-compose"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/R03" class="small-box-footer">More info <i class="fa fa-pencil"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{ttlReceivedCompleted}</h3>
                    <p><?=lang("Ticket Received Completed")?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline"></i>
                </div>
                <a href="<?= site_url() ?>tr/ticketstatus/R04" class="small-box-footer">More info <i class="fa fa-check" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>