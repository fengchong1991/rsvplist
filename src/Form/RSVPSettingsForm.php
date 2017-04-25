<?php
namespace Drupal\rsvplist\Form;


use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;


class RSVPSettingsForm extends ConfigFormBase{
  public function getFormId(){
    return 'rsvplist_admin_settings';
  }

  protected function getEditableConfigNames(){
    return [
      'rsvplist.settings'
    ];
  }



}
