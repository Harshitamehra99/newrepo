<?php
 namespace Drupal\custom_module\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;
 
/**
 * Provides the form for adding countries.
 */
class CustomForm extends FormBase {
 
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['fname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First_Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' =>  '',
    ];
    $form['sname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second_Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' =>  '',
    ];
    $form['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => '',
    ];
    $form['marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Marks'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => '',
    ];
  
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#default_value' => $this->t('Save') ,
    ];
 
    return $form;
  }
 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {
try{
    $conn = Database::getConnection();
    
    $field = $form_state->getValues();
     
    $fields["fname"] = $field['fname'];
    $fields["sname"] = $field['sname'];
    $fields["age"] = $field['age'];
    $fields["marks"] = $field['marks'];
    
      $conn->insert('employee')
         ->fields($fields)->execute();
      \Drupal::messenger()->addMessage($this->t('The Student data has been succesfully saved'));
      $form_state->setRedirect('custom_module.showdata');
     
  } catch(Exception $ex){
    \Drupal::logger('custom_module')->error($ex->getMessage());
  }
    
  }
 
}