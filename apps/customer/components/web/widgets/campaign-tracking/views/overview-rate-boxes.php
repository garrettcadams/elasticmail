<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */

?>

<div class="box borderless">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-16 col-xs-12">
                <div class="box-dashboard">
                    <div class="progress-box">
                        <div class="info">
                            <span class="name"><?php echo Yii::t('campaign_reports', 'Clicks rate');?></span><span class="number"><?php echo $campaign->stats->getUniqueClicksRate(true);?>%</span>
                        </div>
                        <div class="bar"><div class="progress" style="width: <?php echo $campaign->stats->getUniqueClicksRate(true);?>%"></div></div>
                    </div>
                    <ul class="custom-list">
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Unique clicks');?></span><span class="cl-span"><?php echo $campaign->stats->getUniqueClicksCount(true);?> / <?php echo $campaign->stats->getUniqueClicksRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Total clicks');?></span></span><span class="cl-span"><?php echo $campaign->stats->getClicksCount(true);?> / <?php echo $campaign->stats->getClicksRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Clicks to opens rate');?></span></span><span class="cl-span"><?php echo $campaign->stats->getClicksToOpensRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Click through rate');?></span></span><span class="cl-span"><?php echo $campaign->stats->getClicksThroughRate(true);?>%</span></li>
                        <?php if ($campaign->stats->getIndustryClicksRate()) { ?>
                            <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Industry avg({industry})', array('{industry}' => CHtml::link($campaign->stats->getIndustry()->name, Yii::app()->apps->isAppName('customer') ? array('account/company') : 'javascript:;')));?></span> <span class="cl-span"><?php echo $campaign->stats->getIndustryClicksRate(true);?>%</span></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-16 col-xs-12">
                <div class="box-dashboard">
                    <div class="progress-box">
                        <div class="info">
                            <span class="name"><?php echo Yii::t('campaign_reports', 'Opens rate');?></span><span class="number"><?php echo $campaign->stats->getUniqueOpensRate(true);?>%</span>
                        </div>
                        <div class="bar"><div class="progress" style="width: <?php echo $campaign->stats->getUniqueOpensRate(true);?>%"></div></div>
                    </div>
                    <ul class="custom-list">
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Unique opens');?></span><span class="cl-span"><?php echo $campaign->stats->getUniqueOpensCount(true);?> / <?php echo $campaign->stats->getUniqueOpensRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Total opens');?></span></span><span class="cl-span"><?php echo $campaign->stats->getOpensCount(true);?> / <?php echo $campaign->stats->getOpensRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Opens to clicks rate');?></span></span><span class="cl-span"><?php echo $campaign->stats->getOpensToClicksRate(true);?>%</span></li>
                        <?php if ($campaign->stats->getIndustryOpensRate()) { ?>
                            <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Industry avg({industry})', array('{industry}' => CHtml::link($campaign->stats->getIndustry()->name, Yii::app()->apps->isAppName('customer') ? array('account/company') : 'javascript:;')));?></span> <span class="cl-span"><?php echo $campaign->stats->getIndustryOpensRate(true);?>%</span></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-16 col-xs-12">
                <div class="box-dashboard">
                    <div class="progress-box">
                        <div class="info">
                            <span class="name"><?php echo Yii::t('campaign_reports', 'Bounce rate');?></span><span class="number"><?php echo $campaign->stats->getBouncesRate(true);?>%</span>
                        </div>
                        <div class="bar"><div class="progress" style="width: <?php echo $campaign->stats->getBouncesRate(true);?>%"></div></div>
                    </div>
                    <ul class="custom-list">
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Hard bounces');?></span><span class="cl-span"><?php echo $campaign->stats->getHardBouncesCount(true);?> / <?php echo $campaign->stats->getHardBouncesRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Soft bounces');?></span></span><span class="cl-span"><?php echo $campaign->stats->getSoftBouncesCount(true);?> / <?php echo $campaign->stats->getSoftBouncesRate(true);?>%</span></li>
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Internal bounces');?></span></span><span class="cl-span"><?php echo $campaign->stats->getInternalBouncesCount(true);?> / <?php echo $campaign->stats->getInternalBouncesRate(true);?>%</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-16 col-xs-12">
                <div class="box-dashboard">
                    <div class="progress-box">
                        <div class="info">
                            <span class="name"><?php echo Yii::t('campaign_reports', 'Unsubscribe rate');?></span><span class="number"><?php echo $campaign->stats->getUnsubscribesRate(true);?>%</span>
                        </div>
                        <div class="bar"><div class="progress" style="width: <?php echo $campaign->stats->getUnsubscribesRate(true);?>%"></div></div>
                    </div>
                    <ul class="custom-list">
                        <li><span class="cl-span"><?php echo Yii::t('campaign_reports', 'Unsubscribes');?></span><span class="cl-span"><?php echo $campaign->stats->getUnsubscribesCount(true);?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>