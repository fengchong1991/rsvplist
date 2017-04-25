<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\Formbase;
use Drupal\Core\Form\FormStateInterface;


class RSVPForm extends Formbase{


  public function getFormId(){
    return 'rsvplist_email_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state){
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->nid->value;

    $form['email'] = array(
      '#title' => t('email address'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("we will send the the email address"),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('RSVP'),
    );

    $form['nid'] = array(
      '#type' => 'hidden',
      '#value' => $nid,
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state){
    $value = $form_state->getValue('email');
    if ($value == !\Drupal::service('email.validator')->isValid($value)){
      $form_state->setErrorByName('email',t('the address %mail is not valid', array('%mail'=>$value)));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state){
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    db_insert('rsvplist')
    ->fields(array(
      'mail'=>$form_state->getValue('email'),
      'nid' => $form_state->getValue('nid'),
      'uid' => $user->id(),
      'created' => time(),
    ))
    ->execute();
    drupal_set_message(t('thank you foour rsvp, you are on the list for the event'));
  }

}
