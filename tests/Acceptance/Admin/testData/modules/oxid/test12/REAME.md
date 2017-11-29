### Test module #12 for oxajax container-class resolution

This test module might require some short explanation. It is made for
testing admin/oxajax.php functionality and it was needed to make sure
that this ajax call is really done.

NOTE: this module uses metadata Version 1, no module namespaces.

* The module extends the module list menu with a new tab (test_12_tab).
* When you click on that tab, a button named 'CLICK_HERE' is shown.
* Clicking on that button opens a popup.
* The test_12_ajax_controller is reponsible for rendering the popup template.
* The ajax call to admin/oxajax.php is triggered by javascript when the popup gets displayed.
* The module was written to be used with an Acceptance test to verify that admin/oxajax.php
  gets called and the method *_ajax::processRequest in ajax class related to the called controller 
  class gets triggered. (controller: test_12_ajax_controller, ajax class: test_12_ajax_controller_ajax)
* We did not implement any container/drag and drop for the popup but chose a simpler way to 
  verify that the ajax call was indeed processed.
* When the popup gets opened the first time, test_12_ajax_controller assigns the current value of
  a shop confg variable named 'testModule12AjaxCalledSuccessfully' to view data.
* Then it calls test_12_ajax_controller_ajax::getFeedback() to store 'testModule12AjaxCalledSuccessfully' 
  with empty value.
* The popup template gets processed with that view data, so on the first opening of popup, it comes with
  the empty value for 'testModule12AjaxCalledSuccessfully' because the smarty parsing comes before the
  call to admin/oxajax.php is triggered.
* The ajax call then sets value 'test_12_ajax_controller successfully called' for config variable 
  'testModule12AjaxCalledSuccessfully'.
* When popup is opened the next time, we see that variable value from the formerly processed ajax call
  gets shown proving that ajax was indeed called and processed.
  
  