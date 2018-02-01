<h1>Modal</h1>

<div ng-app="dialogDemo1">


<div ng-controller="AppCtrl2" class="md-padding" id="popupContainer">
    <p class="inset">
        Open a dialog over the app's content. Press escape or click outside to close the dialog and
        send focus back to the triggering button.
    </p>

    <div class="dialog-demo-content" layout="row" layout-wrap layout-margin layout-align="center">
        <md-button class="md-primary md-raised" ng-click="showAlert($event)"   >
            Alert Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showConfirm($event)" >
            Confirm Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showPrompt($event)"  >
            Prompt Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showAdvanced($event)">
            Custom Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-click="showTabDialog($event)" >
            Tab Dialog
        </md-button>
        <md-button class="md-primary md-raised" ng-if="listPrerenderedButton" ng-click="showPrerenderedDialog($event)">
            Pre-Rendered Dialog
        </md-button>
    </div>
    <p class="footer">Note: The <b>Confirm</b> dialog does not use <code>$mdDialog.clickOutsideToClose(true)</code>.</p>

    <div ng-if="status" id="status">
        <b layout="row" layout-align="center center" class="md-padding">
            <%status%>
        </b>
    </div>

    <div class="dialog-demo-prerendered">
        <md-checkbox ng-model="listPrerenderedButton">Show Pre-Rendered Dialog</md-checkbox>
        <p class="md-caption">Sometimes you may not want to compile the dialogs template on each opening.</p>
        <md-checkbox ng-model="customFullscreen" aria-label="Fullscreen custom dialog">Use full screen mode for custom dialog</md-checkbox>
        <p class="md-caption">Allows the dialog to consume all available space on small devices</p>
    </div>

    <div style="visibility: hidden">
        <div class="md-dialog-container" id="myDialog">
            <md-dialog layout-padding>
                <h2>Pre-Rendered Dialog</h2>
                <p>
                    This is a pre-rendered dialog, which means that <code>$mdDialog</code> doesn't compile its
                    template on each opening.
                    <br/><br/>
                    The Dialog Element is a static element in the DOM, which is just visually hidden.<br/>
                    Once the dialog opens, we just fetch the element from the DOM into our dialog and upon close
                    we restore the element back into its old DOM position.
                </p>
            </md-dialog>
        </div>
    </div>

</div>
</div>