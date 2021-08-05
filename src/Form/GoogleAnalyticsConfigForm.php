<?php

namespace Drupal\google_analytics_code\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration of admin custom form fields
 */
class GoogleAnalyticsConfigForm extends ConfigFormBase {

    /**
    *  {@inheritdoc}
    */
    public function getFormId() {
        return 'google_analytics_code_config';
    }

    /**
     *  {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'google_analytics_code.settings',
        ];
    }
    /**
    *  {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $config = $this->config('google_analytics_code.settings');

        $form['google_analytics_code_enabled'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Enable Google Analytics Code'),
            '#default_value' => $config->get('google_analytics_code_enabled')
          ];

        $form['google_tracking_code'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Add Google Analytic Tracking Code Here'),
            '#default_value' => $config->get('google_tracking_code')
        ];

        $form['google_tracking_code_show_in'] = [
            '#type' => 'radios',
            '#title' => $this->t('Show Head or Footer Section'),
            '#options' => array($this->t('Head'), $this->t('Footer')),
            '#default_value' => $config->get('google_tracking_code_show_in'),
        ];

        $form['info_use'] = [
            '#type' => 'markup',
            '#markup' => 'NOTE: Add tracking code without script tag'
        ];

        return parent::buildForm($form, $form_state);
    }

    
    /**
     *  {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->configFactory->getEditable('google_analytics_code.settings');

        $config
            ->set('google_tracking_code', $form_state->getValue('google_tracking_code'))
            ->set('google_analytics_code_enabled', $form_state->getValue('google_analytics_code_enabled'))
            ->set('google_tracking_code_show_in', $form_state->getValue('google_tracking_code_show_in'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}

