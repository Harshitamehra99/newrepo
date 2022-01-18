<?php
namespace Drupal\custom_module\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Provides the form for adding countries.
 */
class UpdateForm extends FormBase {

  /**
   * {@inheritdoc}
   */
   public function getFormId() {
    return 'update_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $id =\Drupal:: routeMatch()->getparameter('id');
    $query = \Drupal:: Database();
    $data = $query->select('employee','m')
            ->fields('m',['id','fname','sname','age','marks'])
            ->condition('m.id',$id,'=')
            ->execute()->fetchAll();

    $form['fname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => $data[0]->fname,
    ];
    $form['sname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' =>  $data[0]->sname,
    ];
    $form['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => $data[0]->age,
    ];
    $form['marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Marks'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => $data[0]->marks,
    ];
  
    $form['actions']['#type'] = 'actions';
    $form['actions']['update'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#default_value' => $this->t('Update') ,
    ];
    return $form;
  }
  
   /**
   * {@inheritdoc}
   */
  public function validateForm(array & $form, FormStateInterface $form_state) {
       $field = $form_state->getValues();
     
    $fields["fname"] = $field['fname'];
    if (!$form_state->getValue('fname') || empty($form_state->getValue('fname'))) {
            $form_state->setErrorByName('fname', $this->t('Provide First Name'));
        }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {
    $id =\Drupal:: routeMatch()->getparameter('id');
    $field = $form_state->getValues();
     
    $fields["fname"] = $field['fname'];
    $fields["sname"] = $field['sname'];
    $fields["age"] = $field['age'];
    $fields["marks"] = $field['marks'];

    $query = \Drupal::database();
    $query->update('employee')
          ->fields($fields)
          ->condition('id',$id)->execute();
    \Drupal::messenger()->addStatus('Succesfully Updated.');
    $form_state->setRedirect('custom_module.showdata');
  }
}