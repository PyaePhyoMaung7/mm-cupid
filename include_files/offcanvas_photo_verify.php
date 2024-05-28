<?php
    $error = false;
?>
<div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserPhotoVerify" aria-labelledby="offcanvasUserPhotoVerify">
    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
        <div type="button" ng-click="backUserProfile()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
    </div>
    <div class="offcanvas-body py-0" id="">
        <div id="photo-offcanvas">
            <video id="video" style="display:none; width: 100%; height: 50vh;"></video>
            <canvas id="canvas" style="display:none;"></canvas>
            <img id="photo" style="display:none; width: 100%;" src="" alt="Your photo will appear here">

            <button type="button" ng-click="openCamera()" id="open-camera" class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4" style="width:100%;">
                Open Camera
            </button>
            <button type="button" ng-click="takePhoto()" id="take-photo" class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4" style="width:100%; display: none;">
                Take Photo
            </button>
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" ng-click="sendPhoto()" id="take-photo" class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4 after-photo-taken" style="width:48%; display: none;">
                    Submit
                </button>
                <button type="button" ng-click="resetPhoto()" id="take-photo" class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4 after-photo-taken" style="width:48%; display: none;">
                    Reset
                </button>
            </div>
        </div>
    </div>
</div>

<script>

</script>