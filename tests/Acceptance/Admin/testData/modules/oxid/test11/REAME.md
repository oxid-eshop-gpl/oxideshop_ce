### Test module #11 for oxajax container-class resolution

This test module might require some short explanation. It is made for
testing admin/oxajax.php functionality and it was needed to make sure
that this ajax call is really done.

NOTE: this module uses metadata Version 2 with own module namespaces.

NOTE: we use the following abbreveations here:
* Test11AjaxController = \OxidEsales\EshopCommunity\Tests\Acceptance\Admin\testData\modules\oxid\test11\Application\Controller\Test11AjaxController
* Test11AjaxControllerAjax = \OxidEsales\EshopCommunity\Tests\Acceptance\Admin\testData\modules\oxid\test11\Application\Controller\Test11AjaxControllerAjax



* The module extends the module list menu with a new tab (test_11_tab).
* When you click on that tab, a button named 'CLICK_HERE' is shown.
* Clicking on that button opens a popup.
* The Test11AjaxController is reponsible for rendering the popup template.
* The ajax call to admin/oxajax.php is triggered by javascript when the popup gets displayed.
* The module was written to be used with an Acceptance test to verify that admin/oxajax.php
  gets called and the method *Ajax::processRequest in ajax class related to the called controller 
  class gets triggered. (controller: Test11AjaxController, ajax class: Test11AjaxControllerAjax)
* NOTE: We did not implement any container/drag and drop for the popup but chose a simpler way to 
  verify that the ajax call was indeed processed.
* When the popup gets opened the first time, Test11AjaxController assigns the current value of
  a shop confg variable named 'testModule11AjaxCalledSuccessfully' to view data.
* Then it calls Test11AjaxControllerAjax::getFeedback() to store 'testModule11AjaxCalledSuccessfully' 
  with empty value.
* The popup template gets processed with that view data, so on the first opening of popup, it comes with
  the empty value for 'testModule11AjaxCalledSuccessfully' because the smarty parsing comes before the
  call to admin/oxajax.php is triggered.
* The ajax call then sets value 'test_11_ajax_controller successfully called' for config variable 
  'testModule11AjaxCalledSuccessfully'.
* When popup is opened the next time, we see that variable value from the formerly processed ajax call
  gets shown proving that ajax was indeed called and processed.
  
  