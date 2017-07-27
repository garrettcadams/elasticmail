<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * SubscriberToCampaignQueueTableBehavior
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.8.8
 * 
 */
 
class SubscriberToCampaignQueueTableBehavior extends CActiveRecordBehavior
{
    /**
     * @var string 
     */
    private $_initStatus;

    /**
     * @var bool
     */
    private $_isNewRecord = false;
    
    /**
     * @inheritdoc
     */
    public function afterFind($event)
    {
        parent::afterFind($event);
        $this->_initStatus = $this->owner->status;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($event)
    {
        parent::beforeSave($event);
        $this->_isNewRecord = $this->owner->isNewRecord;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($event)
    {
        parent::afterSave($event);

        // ref
        $owner = $this->owner;
        
        // stop if no email
        if (empty($owner->email)) {
            return;
        }

        // if it's a new record, confirmed
        $allow = $this->_isNewRecord && $owner->status == ListSubscriber::STATUS_CONFIRMED;
        
        // or if existing record but was not confirmed and now confirmed
        if (!$allow && !$this->_isNewRecord) {
            $allow = $this->_initStatus != ListSubscriber::STATUS_CONFIRMED && $owner->status == ListSubscriber::STATUS_CONFIRMED;
        }
        
        if (!$allow) {
            return;
        }

        // make sure successive calls won't succeed
        $this->_initStatus = ListSubscriber::STATUS_CONFIRMED;
        
        $criteria  = new CDbCriteria();
        $criteria->compare('t.list_id', (int)$owner->list_id);
        $criteria->compare('t.type', Campaign::TYPE_AUTORESPONDER);
        $criteria->addNotInCondition('t.status', array(Campaign::STATUS_SENT, Campaign::STATUS_DRAFT, Campaign::STATUS_PENDING_DELETE));

        $criteria->with['option'] = array(
            'together'  => true,
            'joinType'  => 'INNER JOIN',
            'select'    => 'option.autoresponder_include_imported, option.autoresponder_time_value, option.autoresponder_time_unit',
            'condition' => 'option.autoresponder_event = :evt',
            'params'    => array(
                ':evt' => CampaignOption::AUTORESPONDER_EVENT_AFTER_SUBSCRIBE,
            ),
        );
        
        $campaigns = Campaign::model()->findAll($criteria);
 
        foreach ($campaigns as $campaign) {

            // ref
            $campaignOption = $campaign->option;
            
            // if imported are not allowed to receive
            if ($owner->isImported && !$campaignOption->autoresponderIncludeImported) {
                continue;
            }
            
            // if the subscriber does not fall into segments criteria
            if (!empty($campaign->segment_id) && !$campaign->segment->hasSubscriber((int)$owner->subscriber_id)) {
                continue;
            }
            
            $timeValue = (int)$campaignOption->autoresponder_time_value;
            $timeUnit  = strtoupper($campaignOption->autoresponder_time_unit);

            try {
                
                $campaign->queueTable->addSubscriber(array(
                    'subscriber_id' => $owner->subscriber_id,
                    'send_at'       => new CDbExpression(sprintf('DATE_ADD(NOW(), INTERVAL %d %s)', $timeValue, $timeUnit))
                ));
                
            } catch (Exception $e) {
                
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
                
            }
            
        }
    }
}