<div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserProfile" aria-labelledby="offcanvasUserProfile">
    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
        <div type="button" ng-click="backSearchOffcanvas()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
        <div>10 % complete</div>
        <div>Preview</div>
    </div>
    <div class="offcanvas-body py-0">
        <div id="profile-offcanvas">
            <table id="profile-images-table" class="mb-2" style="width: 100%; border-collapse: separate;  table-layout: fixed;">
                <tr>
                    <td class="" colspan="2" rowspan="2">
                        <div class="preview-container bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" ng-click="browseFile()" style="height: 60vh;">
                            <div id="preview1" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('1')" class="btn btn-dark p-2 rounded-3 hide position-absolute change-photo change-photo1" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" style="cursor: pointer" id="upload-icon-1" onclick="browseImage('1')"></i>
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview2" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('2')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo2" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('2')" style="cursor: pointer" id="upload-icon-2"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh; margin-left: 10px;">
                            <div id="preview3" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('3')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo3" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('3')" style="cursor: pointer" id="upload-icon-3"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview4" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('4')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo4" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('4')" style="cursor: pointer" id="upload-icon-4"></i>
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview5" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('5')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo5" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('5')" style="cursor: pointer" id="upload-icon-5"></i>
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview6" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('6')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo6" style="opacity: 0.8" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('6')" style="cursor: pointer" id="upload-icon-6"></i>
                        </div>
                    </td>
                </tr>
            </table>
        
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">{{member.username}}, {{member.age}}</div>
                    <div>{{member.gender}}, {{member.city}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">Work and Education</div>
                    <div>{{member.work}}, {{member.education}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">Why you are here</div>
                    <div>Here to date</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">About me</div>
                    <div>{{member.about}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            
            <div class="p-3 rounded-4 bg-body-tertiary mb-2">
                <div class="fs-5 fw-bold mb-2">Get verified</div>
                <div class="mb-3">Verification ups your chances by showing people they can trust you</div>
                <button class="btn btn-dark w-100 fs-5 rounded-pill"><i class="fa fa-circle-check"></i> Verify By Photo</button>
            </div>
        </div>
    </div>
</div>