<?php

namespace Drupal\myplanet_courses\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Master Progress Circle' Block.
 *
 * @Block(
 *   id = "Master Progress Bar",
 *   admin_label = @Translation("Master Progress Bar"),
 *   category = @Translation("myplanet"),
 * )
 */
class myplanetMasterProgress extends BlockBase implements BlockPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        //My Thought process for this is to grab the settings for the percentage to display and then pass that over to Javascript.
        // but i didn't realize how much Drupal caches everything so if a user does change the percentage it won't update the block unless the cache is cleared.

        $config = $this->getConfiguration();
        if (!empty($config['myplanet_courses_progress'])){
            $percentage = $config['myplanet_courses_progress'];
        }else {
            $percentage = $this->t('0% Complete Training');
        }

        $output = array(
            '#theme' => 'myplanet_courses',
            '#markup' => $this->t('@percentage% Complete Training!', array(
                '@percentage' => $percentage,
            )
            ),
            '#attached' => array(
            // This setting will be sent to drupalSettings.sampleLibrary.mySett ing.
            'drupalSettings' => array(
                'myplanet_courses' => array(
                    'percentage' => $percentage,
                ),
            ),
                'library' => array(
                    'myplanet_courses/circle-progress',
                ),
                ),
        );
        return $output;

    }




    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        $default_config = \Drupal::config('myplanet_courses.settings');
        return array(
            'myplanet_courses_progress' => $default_config->get('progress.percentage'),
        );
    }


    public function blockForm($form, FormStateInterface $form_state)
    {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        $form['myplanet_courses_progress'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Progress'),
            '#description' => $this->t('What percentage do you want to set the user to?'),
            '#default_value' => isset($config['myplanet_courses_progress']) ? $config['myplanet_courses_progress'] : '',
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $value = $form_state->getValues();
        $this->configuration['myplanet_courses_progress'] = $form_state->getValue('myplanet_courses_progress');
    }
    /**
     * {@inheritdoc}
     */
    public function blockValidate($form, FormStateInterface $form_state) {
        $myplanet_courses_progress = $form_state->getValue('myplanet_courses_progress');

        if (!is_numeric($myplanet_courses_progress)) {
            $form_state->setErrorByName('myplanet_courses_progress', t('Needs to be an integer'));
        }
    }
}