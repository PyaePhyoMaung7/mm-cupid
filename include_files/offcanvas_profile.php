<div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserProfile" aria-labelledby="offcanvasUserProfile">
    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
        <div type="button" ng-click="backSearchOffcanvas()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
    </div>
    <div class="offcanvas-body py-0">
        <div id="profile-offcanvas">
            <table id="profile-images-table" class="mb-2" style="width: 100%; border-collapse: separate;  table-layout: fixed;">
                <tr>
                    <td class="" colspan="2" rowspan="2">
                        <div class="preview-container bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" ng-click="browseFile()" style="height: 60vh;">
                            <div id="preview1" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('1')" class="btn btn-dark p-2 rounded-3 hide position-absolute change-photo change-photo1" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" style="cursor: pointer" id="upload-icon-1" onclick="browseImage('1')"></i>
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview2" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('2')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo2" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('2')" style="cursor: pointer" id="upload-icon-2"></i>
                            <button id="delete-btn-2" type="button" class="btn text-decoration-none position-absolute top-0 rounded p-1 m-1 d-none" style="right: 0; outline: none; border: 1px solid transparent;" ng-click="confirmDelete(2)"><i class="fa fa-times fs-5 bg-light rounded-1 shadow"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh; margin-left: 10px;">
                            <div id="preview3" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('3')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo3" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('3')" style="cursor: pointer" id="upload-icon-3"></i>
                            <button id="delete-btn-3" type="button" class="btn text-decoration-none position-absolute top-0 rounded p-1 m-1 d-none" style="right: 0; outline: none; border: 1px solid transparent;" ng-click="confirmDelete(3)"><i class="fa fa-times fs-5 bg-light rounded-1 shadow"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview4" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('4')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo4" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('4')" style="cursor: pointer" id="upload-icon-4"></i>
                            <button id="delete-btn-4" type="button" class="btn text-decoration-none position-absolute top-0 rounded p-1 m-1 d-none" style="right: 0; outline: none; border: 1px solid transparent;" ng-click="confirmDelete(4)"><i class="fa fa-times fs-5 bg-light rounded-1 shadow"></i></button>                       
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview5" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('5')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo5" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('5')" style="cursor: pointer" id="upload-icon-5"></i>
                            <button id="delete-btn-5" type="button" class="btn text-decoration-none position-absolute top-0 rounded p-1 m-1 d-none" style="right: 0; outline: none; border: 1px solid transparent;" ng-click="confirmDelete(5)"><i class="fa fa-times fs-5 bg-light rounded-1 shadow"></i></button>
                        </div>
                    </td>
                    <td class="">
                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                            <div id="preview6" class="d-none w-100 h-100"></div>
                            <label for="" onclick="browseImage('6')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo6" style="opacity: 0.6" >Change</label>
                            <i class="fa fa-upload fs-4" onclick="browseImage('6')" style="cursor: pointer" id="upload-icon-6"></i>
                            <button id="delete-btn-6" type="button" class="btn text-decoration-none position-absolute top-0 rounded p-1 m-1 d-none" style="right: 0; outline: none; border: 1px solid transparent;" ng-click="confirmDelete(6)"><i class="fa fa-times fs-5 bg-light rounded-1 shadow"></i></button>
                        </div>
                    </td>
                </tr>
            </table>

            <input type="file" name="upload1" id="upload1" onchange="previewImage('1')" class="d-none">
            <input type="file" name="upload2" id="upload2" onchange="previewImage('2')" class="d-none">
            <input type="file" name="upload3" id="upload3" onchange="previewImage('3')" class="d-none">
            <input type="file" name="upload4" id="upload4" onchange="previewImage('4')" class="d-none">
            <input type="file" name="upload5" id="upload5" onchange="previewImage('5')" class="d-none">
            <input type="file" name="upload6" id="upload6" onchange="previewImage('6')" class="d-none">

            <div class="p-3 mb-2">
                <button class="btn btn-dark w-100 fs-5 rounded-pill" id="update-photo-btn" ng-click="updatePhoto()"><i class="fa fa-camera"></i> Update Photos</button>
            </div>
        
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">{{member.username}}, {{member.age}}</div>
                    <div>{{member.gender_name}}, {{member.city_name}}</div>
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
                    <div class="fs-5 fw-bold mb-2">About me</div>
                    <div>{{member.about}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">Height</div>
                    <div>{{member.height}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                <div>
                    <div class="fs-5 fw-bold mb-2">Phone</div>
                    <div>{{member.phone}}</div>
                </div>
                <div>
                    <i class="fa fa-chevron-right fs-5"></i>
                </div>
            </div>

            <div class="p-3 mb-2">
                <button class="btn btn-dark w-100 fs-5 rounded-pill" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasUserProfileEdit" aria-controls="offcanvasUserProfileEdit"><i class="fa fa-edit"></i> Edit User Details</button>
            </div>

            <div class="p-3 rounded-4 bg-body-tertiary mb-2">
                <?php
                if($_SESSION['status'] == 1) {
                ?>
                    <div class="fs-5 fw-bold mb-2">Get verified</div>
                    <div class="mb-3">Verification ups your chances by showing people they can trust you</div>
                    <button class="btn btn-dark w-100 fs-5 rounded-pill" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasUserPhotoVerify" aria-controls="offcanvasUserPhotoVerify"><i class="fa fa-check-circle"></i> Verify By Photo</button>
                <?php
                }
                ?>

                <?php
                if($_SESSION['status'] == 2) {
                ?>
                    <div class="fs-5 fw-bold mb-2">Verification Pending <i class="fa fa-circle text-warning" style="font-size: 20px;"></i></div>
                    <div class="mb-3">Admins are checking your photo</div>
                <?php
                }
                ?>

                <?php
                if($_SESSION['status'] == 3) {
                ?>
                    <div class="fs-5 fw-bold mb-2">Verification Denied <i class="fa fa-circle text-danger" style="font-size: 20px;"></i></div>
                    <div class="mb-3">Sorry, we cannot verify you. Please take photo again.</div>
                    <button class="btn btn-dark w-100 fs-5 rounded-pill" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasUserPhotoVerify" aria-controls="offcanvasUserPhotoVerify"><i class="fa fa-check-circle"></i> Verify By Photo</button>
                <?php
                }
                ?>

                <?php
                if($_SESSION['status'] == 4) {
                ?>
                    <div class="fs-5 fw-bold mb-2">Verification Approved <i class="fa fa-circle text-success" style="font-size: 20px;"></i></div>
                    <div class="mb-3">You are now a verified user</div>
                <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</div>
<script>
    function browseImage (index) {
        $('#upload'+index).click();
    }
    
    function previewImage (index) {
        const fileInput = document.getElementById('upload'+index);
        const preview = document.getElementById('preview'+index);

        let fileName = fileInput.value.split('\\').pop();
        let fileExtension = fileName.split('.').pop();

        let allow_extensions = ['jpg','jpeg','png','gif','webp', 'avif'];

        let file = event.target.files[0];

        if(allow_extensions.includes(fileExtension)){
            if(file){
                let reader = new FileReader();
                reader.onload = function(event) {
                let imgSrc = event.target.result;
                preview.innerHTML = `
                <img src= ${imgSrc} class="" style="width: 100%; height: 100%; object-fit: cover" alt="Image Preview"/>
                `;
                };
                reader.readAsDataURL(file);
                preview.style.display = "";
                $('#upload-icon-'+index).hide();
                $('.change-photo'+index).show();
                $('#preview'+index).removeClass('d-none');
                $('#delete-btn-'+index).removeClass('d-none');
                $('#update-photo-btn').prop('disabled', false);
            }
        }else{
            $('#upload'+index).val('');
            $('#preview'+index).innerHTML = "";
            $('.change-photo'+index).hide();
            $('#upload-icon-'+index).show();
            $('#preview'+index).addClass('d-none');
            $('#delete-btn-'+index).addClass('d-none');

            alert('Your uploaded file type is not accepted.');
        };

    }

    const offcanvas_body = document.querySelector('.offcanvas-body')
    offcanvas_body.addEventListener('scroll', function() {
    let offcanvas_header = document.querySelector('.offcanvas-header');
    if (offcanvas_body.scrollTop > 0) {
        offcanvas_header.classList.add('border-bottom', 'border-secondary-subtle');
    } else {
        offcanvas_header.classList.remove('border-bottom', 'border-secondary-subtle');
    }
    });
</script>